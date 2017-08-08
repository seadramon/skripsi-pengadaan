<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		redirect(admin_folder().'/home');
		$this->path          = base_url() . 'home';
		$this->path_uri      = 'home';
		$this->ctrl          = 'home';
		$this->var = array(1, 2, 3);

		$this->load->model('insiden_model');
		$this->load->model('bantuan_model');
		$this->load->model('kebutuhan_model');
	}

	public function index()
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$user = $this->insiden_model->getAll(null, 3, 0)->result_array();
		$bantuan = "";

		$data = array('insidens' => $insidens,
			'bantuan' => $bantuan);

		$this->load->view('frontend/home', $data);
		$this->load->view('frontend/layout/footer');
	}

	private function test()
	{

		print_r($query);die();
	}
}
?>