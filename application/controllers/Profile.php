<?php
/**
* 
*/
class Profile extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        auth_user();
		$this->path          = base_url() . 'profile';
		$this->path_uri      = 'profile';
		$this->ctrl          = 'profile';
        $this->id            = $this->session->userdata('user')['id_user'];

		$this->load->model('frontauth_model');
        $this->load->model('pemberibantuan_model');
	}

    // array untuk validator
    private $arrForm = array('nama' => 'Nama',
                        'birth_date' => 'Tanggal Lahir',
                        'alamat' => 'Alamat',
                        'email' => 'email',
                        'phone' => 'No Telp',
                        'jk' => 'Jenis Kelamin',
                        'currentemail' => 'currentemail',
                        'password' => 'password',
                        'confirm_password' => 'Confirm Password');
    private $error;

	public function index()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $id = $this->id;
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->frontauth_model->updateUser($id, $post);            

            if ($result==1) {
                $this->session->set_flashdata('success_reg', 'Profil berhasil diupdate');
            } else {
                $this->session->set_flashdata('error_reg', 'Profil gagal diupdate');
            }

            redirect($this->path_uri);
        }
        $this->getForm();
	}

	public function getForm()
	{
		$this->load->view('frontend/layout/header');
        $this->load->view('frontend/layout/nav');

        $id               = $this->id;
		$file_app         = $this->ctrl;
        $path_app         = $this->path;
        $path_uri         = $this->path_uri;
        $id               = $id;
        $error_message    = array();
        $post             = array();
        $image            = "";
        $cancel_btn       = site_url($path_uri);
        $success_reg	  = "";

        // Form attribute
        $jk = array('laki-laki' => 'Laki-laki',
        	'perempuan' => 'Perempuan');

        if ($id) {
            $query = $this->frontauth_model->getUser($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }


        if ($id) {
            $action = site_url($path_uri);
        } else {
            $action = site_url($path_uri.'/register');
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('nama',
                        'birth_date',
                        'email',
                        'phone',
                        'alamat',
                        'jk',
                        'password');
        foreach ($arrForm as $fieldName) {
            // set Error
            if (isset($this->error[$fieldName])) {
                $error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
            } else {
                $error_message[$fieldName] = '';
            }

            // set value
            if ($fieldName!="password") {
                if ($this->input->post($fieldName) != '') {
                    $post[$fieldName] = $this->input->post($fieldName);
                } elseif (strlen($id)>0) {
                    $post[$fieldName] = $row[$fieldName];
                } else {
                    $post[$fieldName] = '';
                }
            }
        }

        $post = array($post);
        $error_message = array($error_message);
       	$success_reg = alert_box($this->session->flashdata('success_reg'), 'success');

        $data = array(
            'base_url'    => base_url(),
            'post'        => $post,
            'action'      => $action,
            'error_msg'   => $error_message,
            'success_reg' => $success_reg,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'jk'	      => $jk,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/profile', $data);
        $this->load->view('frontend/layout/footer');
	}

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            $post['nama'] = ucwords($post['nama']);
            $post['role'] = 'pemberibantuan';
            $post['password'] = md5($post['password']);
            unset($post['confirm_password']);
            unset($post['currentemail']);
        }
    }

    private function validateForm()
    {
        $post = purify($this->input->post());

        foreach ($this->arrForm as $fieldName => $fieldValue) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldValue.' Cannot be empty';    
            } else {
                if($fieldName=='telp') {
                    if (!ctype_digit($post[$fieldName])) {
                        $this->error[$fieldName] = $fieldValue.' Harus dalam bentuk angka';            
                    }
                }

                if ($fieldName=='email') {
                    if (!filter_var($post[$fieldName], FILTER_VALIDATE_EMAIL)) {
                        $this->error[$fieldName] = $fieldValue.' Tidak valid';
                    } else {
                        if ($post['currentemail']!=$post[$fieldName]) {
                            $jml = $this->pemberibantuan_model->userExist($post[$fieldName]);
                            if ($jml>0) {
                                $this->error[$fieldName] = 'Email sudah digunakan'; 
                            }
                        }
                    }
                }
            }
        }

        if ($post['password']!="" && $post['confirm_password']!="") {
            if ($post['password']!=$post['confirm_password']) {
                $this->error['password'] = "Konfirmasi Password tidak sesuai";
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}