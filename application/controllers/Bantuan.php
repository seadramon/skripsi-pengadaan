<?php 
/**
* 
*/
class Bantuan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->path          = base_url() . 'bantuan';
		$this->path_uri      = 'bantuan';
		$this->ctrl          = 'bantuan';

		$this->load->model('insiden_model');
		$this->load->model('kebutuhan_model');
		$this->load->model('bantuan_model');
	}

	private $error;

	public function index($id_insiden)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$insiden = $this->insiden_model->showById($id_insiden)->row_array();
		$kebutuhan =  $this->kebutuhan_model->getTipeKebutuhan($id_insiden);
		$data = array('insiden' => $insiden,
				'kebutuhan' => $kebutuhan);
		
		$this->load->view('frontend/bantuan/home', $data);
		$this->load->view('frontend/layout/footer');
	}

	public function getForm($id_tipe, $id_insiden)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$error_message = array();
		$path_uri    = $this->path_uri;
		$insiden 	 = $this->insiden_model->showById($id_insiden)->row_array();
		$kebutuhan 	 = $this->kebutuhan_model->getByInsiden($id_tipe, $id_insiden);
		$action 	 = site_url($path_uri."/add/$id_tipe/$id_insiden");
		$tipe 		 = $this->db->get_where('tipe', array('id_tipe' => $id_tipe))->row('nama');
		$pos 		 = get_combobox(sprintf("SELECT id_poslogistik, nama FROM pos_logistik where id_insiden = '%s'", $id_insiden), "id_poslogistik", "nama", "-Pilih Lokasi-");

		if ($this->error) {
			foreach ($this->error as $key => $value) {
				$error_message[$key] = alert_box($value, 'error');
			}
		}
		$cancel_btn = $this->path_uri.'/index/'.$id_insiden;

		$data = array('path_uri' => $path_uri,
				'tipe' => $tipe,
				'pos' => $pos,
				'insiden' => $insiden,
				'kebutuhan' => $kebutuhan,
				'action' => $action,
	            'error_msg'   => $error_message,
	            'cancel_btn'  => $cancel_btn);

        $this->load->view('frontend/bantuan/add', $data);
		$this->load->view('frontend/layout/footer');
	}

	public function homeDana($id_insiden)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');
		$this->load->model('organisasi_model');

		$path_uri         = $this->path_uri;
		$insiden = $this->insiden_model->showById($id_insiden)->row_array();
		$bank = $this->organisasi_model->organisasi_bank($insiden['id_organisasi']);
		$error_message = "";
		$cancel_btn = $this->path_uri.'/index/'.$id_insiden;

		$data = array(
			'path_uri' => $path_uri,
			'bank' => $bank,
			'insiden' => $insiden,
            'error_msg'   => $error_message,
            'cancel_btn'  => $cancel_btn
        );
        $this->load->view('frontend/bantuan/homeDana', $data);
		$this->load->view('frontend/layout/footer');
	}

	public function getFormDana($id_insiden)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');
		$this->load->model('organisasi_model');

		$path_uri         = $this->path_uri;
		$insiden = $this->insiden_model->showById($id_insiden)->row_array();
		$str = sprintf("SELECT organisasi_bank.id_organisasi_bank, bank.nama FROM organisasi_bank 
			left join bank on organisasi_bank.id_bank = bank.id_bank
			where id_organisasi = '%s'", $insiden['id_organisasi']);
		$bank = get_combobox($str, "id_organisasi_bank", "nama", "-Pilih Bank Tujuan-");
		$action = site_url($path_uri."/addDana/$id_insiden");
		$error_message = "";
		$cancel_btn = $this->path_uri.'/index/'.$id_insiden;

		if ($this->error) {
			foreach ($this->error as $key => $value) {
				$error_message[$key] = alert_box($value, 'error');
			}
		}
		$cancel_btn = $this->path_uri.'/index/'.$id_insiden;

		$data = array(
			'path_uri' => $path_uri,
			'action' => $action,
			'bank' => $bank,
			'insiden' => $insiden,
            'error_msg'   => $error_message,
            'cancel_btn'  => $cancel_btn
        );
        $this->load->view('frontend/bantuan/addDana', $data);
		$this->load->view('frontend/layout/footer');
	}

	public function add($tipe, $id_insiden)
	{
		auth_user();
		if ($this->session->userdata('user')['role']=='pemberibantuan') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
	            $post = purify($this->input->post());
	            $detail = array();
	            $post['id_insiden'] = $id_insiden;
	            $post['id_tipe'] = $tipe;
	            $detail = $post['kebutuhan'];

	            $this->replacer($post);
	            $result = $this->bantuan_model->insert($post, $detail);     

	            if ($result==1) {
	            	$this->session->set_flashdata('success_msg', 'Bantuan berhasil disubmit');
	            	redirect($this->path_uri.'/konfirmasi/');
	            } else {
	                $this->session->set_flashdata('error_msg', 'Maaf, bantuan tidak dapat disubmit');
	            }
	            redirect($this->path_uri.'/index/'.$id_insiden);

	        }
	        $this->getForm($tipe, $id_insiden);
	    } else {
	    	$this->load->view('frontend/layout/header');
			$this->load->view('frontend/layout/nav');
	    	$data['information'] = "Maaf, anda harus login sebagai Pemberi Bantuan untuk mengakses halaman ini.";
	    	$data['sukses'] = 'no';
			$this->load->view('frontend/layout/information', $data);
			$this->load->view('frontend/layout/footer');
	    }
	}

	public function addDana($id_insiden)
	{
		auth_user();
		if ($this->session->userdata('user')['role']=='pemberibantuan') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateFormDana()) {
	            $post = purify($this->input->post());
	            $parent = array('id_bantuan' => uuid(),
	            	'id_user' => $this->session->userdata('user')['id_user'],
	            	'id_tipe' => $this->db->get_where('tipe', array('nama' => 'Dana'))->row('id_tipe'),
	            	'id_insiden' => $id_insiden,
	            	'is_fund' => '1',
	            	'created' => date('Y-m-d'),
	            	/*'status' => 'submitted'*/);
	            $post['id_danabantuan'] = uuid();
	            $post['id_bantuan'] = $parent['id_bantuan'];
	            $post['status'] = 'submitted';
	            $result = $this->bantuan_model->insertDana($parent, $post);     

	            if ($result==1) {
	            	$this->session->set_flashdata('success_msg', 'Bantuan berhasil disubmit');
	            	redirect($this->path_uri.'/konfirmasi/');
	            } else {
	                $this->session->set_flashdata('error_msg', 'Maaf, bantuan tidak dapat disubmit');
	            }
	            redirect($this->path_uri.'/index/'.$id_insiden);

	        }
	        $this->getFormDana($id_insiden);
	    } else {
	    	$this->load->view('frontend/layout/header');
			$this->load->view('frontend/layout/nav');
	    	$data['information'] = "Maaf, anda harus login sebagai Pemberi Bantuan untuk mengakses halaman ini.";
	    	$data['sukses'] = 'no';
			$this->load->view('frontend/layout/information', $data);
			$this->load->view('frontend/layout/footer');
	    }
	}

	public function konfirmasi()
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');
		$data['information'] = "Terima Kasih, Bantuan Anda telah berhasil disubmit";
		$data['sukses'] = "yes";
		$this->load->view('frontend/layout/information', $data);
		$this->load->view('frontend/layout/footer');
	}

	private function replacer(&$post)
	{
		unset($post['dropPostCheck']);
		unset($post['kebutuhan']);
		$post['id_user'] = $this->session->userdata('user')['id_user'];
		$post['is_fund'] = '0';
		$post['created'] = date('Y-m-d');
		// $post['status'] = 'submitted';
	}

	private function validateForm()
	{
		$post = purify($this->input->post());

		if (count($post['kebutuhan']) > 0) {
			foreach ($post['kebutuhan'] as $key => $value) {
				if ($value!='') {
					if (!ctype_digit($value)) {
						$this->error['quantity'] = "Quantity harus dalam bentuk angka";
					}
				}
			}
		}

		if ($post['dropPostCheck']=='bisa') {
			if ($post['id_poslogistik']=='') {
				$this->error['id_poslogistik'] = "Anda belum memilih titik drop off";
			}
		} else {
			if ($post['alamat']=='') {
				$this->error['alamat'] = "Anda belum mengisi alamat";
			}

			if ($post['transportasi']=='') {
				$this->error['transportasi'] = "Anda belum memilih angkutan yang diperlukan";
			}
		}

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
	}

	private function validateFormDana()
	{
		$post = purify($this->input->post());
		$number = array('nomor_akun', 'phone', 'quantity');

		if (count($post) > 0) {
			foreach ($post as $key => $value) {
				if ($value=="" && $key!="deskripsi") {
					$this->error[$key] = $key." belum diisi";
				} else {
					if (in_array("key", $number)) {
						if (!ctype_digit($value)) {
							$this->error[$key] = $key." harus dalam bentuk angka";
						}
					}
				}
			}
		}

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
	}

	public function updateBantuan($tipe, $id_insiden, $id_bantuan)
	{
		auth_user();
		if ($this->session->userdata('user')['role']=='korlap' || $this->session->userdata('user')['role']=='korlog') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateFormUpdateBantuan()) {
	            $post = purify($this->input->post());
	            $detail = $post['detailBantuan'];

	            $result = $this->bantuan_model->updateBantuan($detail);     

	            if ($result==1) {
	            	$this->session->set_flashdata('success_msg', 'Bantuan berhasil diupdate');
	            } else {
	                $this->session->set_flashdata('error_msg', 'Maaf, bantuan tidak dapat disubmit');
	            }
	            redirect($this->path_uri."/updateBantuan/$tipe/$id_insiden/$id_bantuan");

	        }
	        $this->getFormUpdateBantuan($tipe, $id_insiden, $id_bantuan);
	    } else {
	    	$this->load->view('frontend/layout/header');
			$this->load->view('frontend/layout/nav');
	    	$data['information'] = "Maaf, anda harus login sebagai Pemberi Bantuan untuk mengakses halaman ini.";
	    	$data['sukses'] = 'no';
			$this->load->view('frontend/layout/information', $data);
			$this->load->view('frontend/layout/footer');
	    }
	}

	public function getFormUpdateBantuan($tipe, $id_insiden, $id_bantuan)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');
		$this->load->model('organisasi_model');

		$path_uri         = $this->path_uri;
		$tabtipe 		  = $this->bantuan_model->tipe();
		$insiden 		  = $this->insiden_model->showById($id_insiden)->row_array();
		$valueUpdate	  = $this->bantuan_model->getFormUpdate($tipe, $id_insiden, $id_bantuan);
		$action 		  = site_url($path_uri."/updateBantuan/$tipe/$id_insiden/$id_bantuan");
		$error_message 	  = "";
		$tipenya		  = $this->db->get_where('tipe', array('id_tipe' => $tipe))->row('nama');
		$cancel_btn 	  = site_url("insiden/bantuan/$id_insiden/$tipenya");
		$success_msg 	  = alert_box($this->session->flashdata('success_msg'), 'success');

		// echo $tipe;die();

		if ($this->error) {
			foreach ($this->error as $key => $value) {
				$error_message[$key] = alert_box($value, 'error');
			}
		}
		$data = array(
			'path_uri' 		=> $path_uri,
			'action' 		=> $action,
			'tabtipe'     	=> $tabtipe,
			'tipe'			=> $tipenya,
			'insiden' 		=> $insiden,
			'valueUpdate'   => $valueUpdate,
            'error_msg'   	=> $error_message,
            'success_msg'	=> $success_msg,
            'cancel_btn'  	=> $cancel_btn
        );
        // print_r($data);
        $this->load->view('frontend/aturbantuan/header', $data);
        $this->load->view('frontend/aturbantuan/updateBantuan', $data);
		$this->load->view('frontend/layout/footer');
	}

	private function validateFormUpdateBantuan()
	{
		$post = purify($this->input->post());
		$detail = $post['detailBantuan'];

		if (count($detail) > 0) {
			foreach ($detail as $value) {
				$jml = 0;
				if ($value['qtyTerima']!="") {
					if (!ctype_digit($value['qtyTerima'])) {
						$this->error[$value['item']] = "Quantity ".$value['item']." harus dalam bentuk angka";
					}

					$jml = $value['qtyTerima'] + $value['quantity_received'];
					if ($jml > $value['quantity']) {
						$this->error[$value['item']] = "Quantity ".$value['item']." tidak bisa melebihi dari yang didonasikan";
					}

					if ($value['qtyTerima'] < 0) {
						$this->error[$value['item']] = "Quantity ".$value['item']." tidak boleh minus";
					}
				}
			}
		}

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
	}
}
?>