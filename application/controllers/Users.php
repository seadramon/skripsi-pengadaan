<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Users extends CI_Controller
{
	private $max_width;
	private $max_height;

	function __construct()
	{
		parent::__construct();
		$this->max_width = 281;
		$this->max_height = 392;
		$this->load->model('frontauth_model');
	}

	function index()
	{

	}

	public function login()
	{
		$error_login = ($this->session->flashdata('error_login') != '') ? $this->session->flashdata('error_login') : '';
		$data = array(
            'base_url'    => base_url(),
            'login'       => '',
            'password'    => '',
            'error_login' => $error_login
        );
		if (strtolower($_SERVER['REQUEST_METHOD'])=='post' && $this->validateForm()) {
			$post = purify($this->input->post());
			$this->frontauth_model->login($post['email'], $post['password']);
		}
		$this->load->view('frontend/layout/login', $data);
	}

	private function validateForm()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $error = "";
            $post = purify($this->input->post());
            $email = isset($post['email'])?$post['email']:"";

            if ($post['email'] == '' || $post['password'] == '') {
                $this->session->set_flashdata('error_login', 'Masukkan Email dan Password<br/>');
                redirect(base_url() . 'users/login');
            } else {
                if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->session->set_flashdata('error_login', 'Email tidak valid.<br/>');
                	redirect(base_url() . 'users/login');
                }
            }
            return true;
        }
        return false;
    }

	public function create()
	{
		$data = array('group_id' => 1,
					  'email' => 'admin@mataharimall.com',
					  'password' => $this->phpass->hash('matahari123'),
					  'name' => 'Matahari',
					  'phone' => '6285645202030',
					  'created_at' => date('Y-m-d H:i:s'),
					  'updated_at' => date('Y-m-d H:i:s'));
		$ret = $this->auth_model->create($data);
		echo $ret;
	}

	public function gen_password()
	{
		$var = 'damar123';
		echo $this->phpass->hash($var);
	}

	public function logout($role = "")
	{
		$this->session->sess_destroy();
		header("Location:".base_url());
	}
}
?>