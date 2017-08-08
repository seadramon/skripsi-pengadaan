<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('admpage/customer_model');
	}

	public function index()
	{
		//nothing
	}

	public function login()
	{
		$input = $this->input->post();

		if ($this->auth->login($input['email'], $input['password'])) {
			//if the login is successful
			$this->db->where('email', $input['email']);
			$this->db->update('auth_user', array('device' => $input['device']));

			$this->db->where('email', $input['email']);
			$user = $this->db->get('auth_user')->row();

			$user_data = array(
				'id'     => $user->id_auth_user,
				'name'   => $user->name,
				'email'  => $user->email,
				'avatar' => base_url() . 'uploads/ava/' . $user->avatar,
				'nik'    => $user->nik,
				'jabatan'=> $user->jabatan,
				'wilayah'=> $user->wilayah,
			);

			$resp = array(
				'status' => 'success',
				'data'   => array('user' => $user_data),
			);
		} else {
			//if the login was un-successful
			$resp = array(
				'status' => 'fail',
				'data'   => array('message' => 'Invalid email and password combination'),
			);
		}

		send_json($resp);
	}

	public function register()
	{
		$input = $this->input->post();

		$this->db->where('email', $input['email']);
		$identity = $this->db->get('auth_user');

		if ($identity->num_rows() > 0) {
			//if the email is in the database
			$user = $identity->row();

			if ($this->auth->register($user->email)) {
//				$resp = array(true);
				$resp = [
					'status' => 'success',
					'data'   => [
						'message' => 'Registrasi berhasil. Password telah kami kirim ke email anda.',
					],
				];
			} else {
//				$resp = array(false);
				$resp = [
					'status' => 'fail',
					'data'   => [
						'message' => 'Email anda telah terdaftar. Silahkan gunakan fitur forgot password untuk mereset password anda',
					],
				];
			}
		} else {
			//if the email is not in the database
//			$resp = array(false);
			$resp = [
				'status' => 'fail',
				'data'   => [
					'message' => 'Email yang anda masukkan tidak terdaftar.',
				],
			];
		}

		send_json($resp);
	}

	public function forgot_password()
	{
		$input = $this->input->post();
		$this->db->where('email', $input['email']);

		if ($this->auth->forgotten_password($input['email'])) {
			//if the login is successful
			$resp = array(true);
		} else {
			//if the login was un-successful
			$resp = [
				'status' => 'fail',
				'data'   => [
					'message' => 'Email yang anda masukkan tidak terdaftar.',
				],
			];
		}

		send_json($resp);
	}

	public function event()
	{
		$this->load->model('admpage/event_model', 'event');
		$input = $this->input->get();

		if (empty($input['id'])) {
			$this->db->select('DATE(schedule) AS schedule');
			$this->db->group_by('schedule');
			$events = $this->db->get('event')->result_object();

			if (count($events) > 0) {
				foreach ($events as $event) {
					$item = '';
					$this->db->where('DATE(schedule)', $event->schedule);
					$query = $this->db->get('event')->result_object();
					if (count($query) > 0) {
						foreach ($query as $row) {
							$item[] = array(
								'id' => $row->id,
								'time' => $row->schedule,
								'name' => $row->name,
								'active' => $row->is_active,
							);
						}
					}

					$resp[] = array(
						'section_name' => date('l, F d Y', strtotime($event->schedule)),
						'item' => $item,
					);
				}
			} else {
				$resp = array(false);
			}
		} else {
			$event = $this->event->get($input['id'])->row();

			if (count($event) > 0) {
				$resp = array(
					'id'       => $event->id,
					'time'     => $event->schedule,
					'name'     => $event->name,
					'location' => $event->location,
					'address'  => $event->address,
					'active'   => $event->is_active,
				);
			} else {
				$resp = array(false);
			}
		}

		send_json($resp);
	}

	public function content_mr()
	{
		$this->load->model('admpage/content_model', 'content');
		$input = $this->input->get();

		if (isset($input['event_id'])) {
			$contents = $this->content->get_mr_by_event($input['event_id'], true)->result_object();

			if (count($contents) > 0) {
				foreach ($contents as $content) {
					$resp[] = array(
						'id'    => $content->id,
						'title' => $content->title,
						'image' => ($content->image != '' ? base_url() . 'uploads/contents/' . $content->image : ''),
					);
				}
			} else {
				$resp = array(false);
			}
		} elseif (isset($input['id'])) {
			$content = $this->content->get_mr($input['id'])->row();

			if (count($content) > 0) {
				$image   = '<img src="'.base_url() . 'uploads/contents/' . $content->image.'" style="width:100%">';
				$title   = $content->title;
				$content = $content->content;
			} else {
				$image   = '';
				$title   = 'Content Not Found';
				$content = 'Your requested content cannot be found. Please consult your administrator.';
			}

			echo '<html>
				<head>
				<title>'. $title .'</title>
				<style>
					#wrapper { width: 100%; }
				</style>
				</head>
				<body>
					<div id="wrapper">
					    '. $image .'
						<h2 style="font-size: 30px; font-family: \'Helvetica Neue\';"> '. $title .' </h2>

						'. $content .'
					</div>
				</body>
				</html>';
			return;
		} else {
			$contents = $this->content->get_mr_all()->result_object();

			if (count($contents) > 0) {
				foreach ($contents as $content) {
					$resp[] = array(
						'id'    => $content->id,
						'title' => $content->title,
						'image' => ($content->image != '' ? base_url() . 'uploads/contents/' . $content->image : ''),
					);
				}
			} else {
				$resp = array(false);
			}
		}

		send_json($resp);
	}

	public function content_sa()
	{
		$this->load->model('admpage/content_model', 'content');
		$input = $this->input->get();

		if (isset($input['event_id'])) {
			$contents = $this->content->get_sa_by_event($input['event_id'])->result_object();

			if (count($contents) > 0) {
				foreach ($contents as $content) {
					$resp[] = array(
						'id'    => $content->id,
						'title' => $content->title,
						'image' => ($content->image != '' ? base_url() . 'uploads/contents/' . $content->image : ''),
					);
				}
			} else {
				$resp = array(false);
			}
		} elseif (isset($input['id'])) {
			$content = $this->content->get_sa($input['id'])->row();

			if (count($content) > 0) {
				$img     = ($content->image != '' ? '<img src="' . base_url() . 'uploads/contents/' . $content->image .'" style="width:100%">' : '');
				$title   = $content->title;
				$content = $content->content;
			} else {
				$img     = '';
				$title   = 'Content Not Found';
				$content = 'Your requested content cannot be found. Please consult your administrator.';
			}

			echo '<html>
				<head>
				<title>'. $title . '</title>
				<style>
					#wrapper { width: 100%; }
				</style>
				</head>
				<body>
					<div id="wrapper">
						'. $img .'

						'. $content . '
					</div>
				</body>
				</html>';
			return;
		} else {
			$contents = $this->content->get_sa_all()->result_object();

			if (count($contents) > 0) {
				foreach ($contents as $content) {
					$resp[] = array(
						'id'    => $content->id,
						'title' => $content->title,
						'image' => ($content->image != '' ? base_url() . 'uploads/contents/' . $content->image : ''),
					);
				}
			} else {
				$resp = array(false);
			}
		}

		send_json($resp);
	}

	public function attendance()
	{
		$input = $this->input->post();

		if (empty($input['event_id']) || empty($input['user_id']) || empty($input['lat']) || empty($input['long'])) {
			$resp = array(false);
		} else {
			$data = array(
				'event_id'    => $input['event_id'],
				'user_id'     => $input['user_id'],
				'latitude'    => $input['lat'],
				'longitude'   => $input['long'],
				'device_type' => $input['device'],
				'created_by'  => $input['user_id'],
				'created_at'  => date('Y-m-d H:i:s'),
			);
			$this->db->insert('attendances', $data);

			$resp = array(true);
		}

		send_json($resp);
	}

	public function check_attendance()
	{
		$input = $this->input->get();

		if (empty($input['event_id']) || empty($input['user_id']) || !ctype_digit($input['event_id']) || !ctype_digit($input['user_id'])) {
			$resp = array(false);
		} else {
			$this->db->where('event_id', $input['event_id']);
			$this->db->where('user_id', $input['user_id']);
			$query = $this->db->get('attendances')->num_rows();

			if ($query > 0) {
				$resp = array(true);
			} else {
				$resp = array(false);
			}
		}

		send_json($resp);
	}

	public function group()
	{
		$this->load->model('admpage/gaming_group_model', 'group');
		$input = $this->input->get();

		if (empty($input['id'])) {
			$groups = $this->group->get_all()->result_object();

			if (count($groups) > 0) {
				foreach ($groups as $group) {
					$resp[] = array(
						'id'   => $group->id,
						'name' => $group->name,
					);
				}
			} else {
				$resp = array(false);
			}
		} else {
			$group = $this->group->get($input['id'])->row();
			$members = $this->group->show_member($input['id'])->result_object();
			$score = $this->group->get_score($input['id']);

			if (count($group) > 0) {
				$resp['id'] = $group->id;
				$resp['name'] = $group->name;
				$resp['score'] = $score;

				if (count($members) > 0) {
					foreach ($members as $member) {
						$resp['member'][] = array(
							'id'       => $member->id_auth_user,
							'name'     => $member->name,
							'user_nik' => $member->nik,
							'wilayah'  => $member->wilayah,
							'avatar'   => base_url() . 'uploads/ava/' . $member->avatar,
						);
					}
				}
			} else {
				$resp = array(false);
			}
		}

		send_json($resp);
	}

	public function group_rank()
	{
		$input = $this->input->get();
		$event_id = (isset($input['event_id'])) ? $input['event_id'] : null;
		$game_id = (isset($input['game_id'])) ? $input['game_id'] : null;

		$this->load->model('admpage/gaming_group_model', 'group');
		$groups = $this->group->get_ranked($event_id, $game_id)->result_object();

		if (count($groups) > 0) {
			foreach ($groups as $group) {
				$resp[] = array(
					'id'    => $group->id,
					'name'  => $group->name,
					'score' => ($group->score != '' ? number_format($group->score) : 0),
				);
			}
		} else {
			$resp = array(false);
		}

		send_json($resp);
	}

	public function save_score()
	{
		$input = $this->input->get();

		if (ctype_digit($input['event_id']) && ctype_digit($input['game_id']) && ctype_digit($input['group_id']) && ctype_digit($input['score'])) {
			$data = [
				'event_id' => $input['event_id'],
				'game_id'  => $input['game_id'],
				'group_id' => $input['group_id'],
				'score'    => $input['score'],
				'created_at' => date('Y-m-d H:i:s'),
			];

			$this->db->insert('scores', $data);

			$resp = array(true);
		} else {
			$resp = array(false);
		}

		send_json($resp);
	}
}