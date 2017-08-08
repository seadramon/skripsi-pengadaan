<?php
/**
* 
*/
class Organisasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->template      = 'frontend/organisasi/';
		$this->load->model(admin_folder() . '/organisasi_model');
	}

	private $arrForm = array('nama' => 'nama',
                         'email' => 'email', 
                         'phone' => 'phone',
                         'pic' => 'penanggungjawab',
                         'postal' => 'postal');
    private $error;

	public function index()
	{

	}

	public function register()
	{
		$error_message = array();
		$success_message = array();
		$error_session 	 = alert_box($this->session->flashdata('error_sess'), 'error');

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateRegister()) {
			$post = purify($this->input->post());
			$this->replacer($post);

			if (!empty($_FILES['dokumen']['name'])) {
				$file = $this->uploadFile($post['nama']);

				if ($file)
				$post['file'] = $file;

				$this->load->model('organisasi_model');
				$result = $this->organisasi_model->insert($post);

				if ($result) {
					$success_message['registrasi'] = alert_box('Pendaftaran organisasi berhasil disubmit', 'success');
				} else {
					$error_message['registrasi'] = alert_box('Pendaftaran organisasi gagal disubmit', 'error');	
				}
			} else {
				$error_message['dokumen'] = alert_box('Wajib mengupload dokumen AD/ART', 'error');
			}
		}

		foreach ($this->arrForm as $fieldName => $val) {
	    	// set Error
	    	if (isset($this->error[$fieldName])) {
	        	$error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        }
	    }

	    $data = array('error_msg' => $error_message,
	    			'success_msg' => $success_message,
	    			'error_sess' => $error_session
	    );

		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$this->load->view($this->template.'registrasi', $data);
		$this->load->view('frontend/layout/footer');
	}

	public function uploadFile($name) {
        $directory = $this->config->item('base_document');
        // echo $directory;die();
        $filename = $_FILES['dokumen']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $itemValue = str_replace(" ", "_", $name). '_' . uniqid() . '.' . $ext;
        $config['upload_path'] = $directory;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
        $config['file_name'] = $itemValue;
        $config['max_file_uploads'] = 1;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('dokumen')) {
            return $itemValue;
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error_sess', 'File gagal diupload');
            
            redirect(base_url().'organisasi/register');
        }
    }

	private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            $post['nama'] = ucwords($post['nama']);
            $post['created'] = date('Y-m-d');
        }
    }

	private function validateRegister()
	{
		$post = purify($this->input->post());

		foreach ($this->arrForm as $fieldName => $val) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = ucwords($val).' Tidak Boleh Kosong';    
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
	}

	public function createuser($confcode)
	{
		$valConfcode = $this->organisasi_model->getByConfirmcode($confcode);
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		if ($valConfcode) {
			/*$organisasi = $this->organisasi_model->getByConfirmcode($confcode);
			$emailAdmin = isset($organisasi['email'])?$organisasi['email']:"";
			if ($emailAdmin!="") {
				$dataAdmin = array("id_user" => uuid(),
							"nama" => $organisasi['nama'].' Admin',
							"email" => $organisasi['email'],
							"role" => "admin_org",
							"group_id" => 3,
							"password" => md5("bantuin"));

				$confirm = $this->organisasi_model->insertUserAdminorg($dataAdmin, $confcode, $organisasi['id_organisasi']);
				if ($confirm) {
					$this->session->set_userdata('tmp_url', base_url().'userorganisasi');

					$this->load->model('frontauth_model');
					$this->frontauth_model->login($dataAdmin['email'], "bantuin");
				}
			}*/


			$error_message = array();
			$success_message = array();
			$error_session 	 = alert_box($this->session->flashdata('error_sess'), 'error');

			// error notification
			if (count($this->error) > 0 && is_array($this->error)) {
				foreach ($this->error as $key => $value) {
					$error_message[$key] = alert_box($value, 'error');
				}
			}

			$organisasi = $this->organisasi_model->getByConfirmcode($confcode);
			$role = array("" => '-Pilih Jabatan-',
						"leader" => "Leader",
						"admin_org" => "Admin Organisasi",
						"korlog" => "Korlog",
						"korlap" => "Korlap");

			$data = array('error_msg' => $error_message,
		    			'success_msg' => $success_message,
		    			'error_sess' => $error_session,
		    			'organisasi' => $organisasi,
		    			'confcode' => $confcode,
		    			'role' => $role);
			$this->load->view('frontend/organisasi/createuser', $data);
			$this->load->view('frontend/layout/footer');
		} else {
			$data = array('information' => 'Konfirmasi Kode tidak ditemukan',
				'sukses' => 'no');
			$this->load->view('frontend/layout/information', $data);
			$this->load->view('frontend/layout/footer');
		}
	}

	public function submitUser()
	{
		if ($_SERVER['REQUEST_METHOD']=='POST' && $this->validateUser()) {
			// print_r($_POST);die();
			$post = purify($this->input->post());
			$result = $this->organisasi_model->insertUser($post);

			if ($result) {
				echo ("<SCRIPT LANGUAGE='JavaScript'>window.alert('User berhasil disubmit, silakan cek email untuk mendapatkan akses login')
					window.location.href='http://silver.dev/bantuin';
    			</SCRIPT>");
			}
		} else 
		$this->createuser($this->input->post('confirmation_code'));
	}

	private function validateUser()
	{
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$arrUser = array('nama', 'email', 'role');
			$post = purify($this->input->post());

			$i = 0;
			$errorAtr = array();
			$arrVal = array('nama', 'email', 'role');
			if (is_array($post['user']) && count($post['user']) > 0) {
				foreach ($post['user'] as $row) {
					foreach ($arrVal as $validate) {
						if ($row[$validate]=='') {
							$this->error[$validate] = sprintf("Field %s wajib diisi.", $validate);
						} else {
							if ($validate=='email') {
								if (!filter_var($row[$validate], FILTER_VALIDATE_EMAIL)) {
									$this->error[$validate.' invalid'] = "Email tidak valid";
								} else {
									$this->load->model(admin_folder() . '/user_model');
									$valEmail = $this->user_model->cekEmail($row[$validate]);
									if ($valEmail > 0) {
										$this->error[$validate.' exists'] = "Email sudah digunakan";	
									}
								}
							}
						}
					}
				}
			}
			if (count($this->error) > 0) {
				return false;
			} else {
				return true;
			}
		}
	}
}
?>