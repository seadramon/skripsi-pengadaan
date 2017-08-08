<?php 
class Homepage extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// print_r('cok');die();
		header("Location:".base_url().'admpage/login');
	}
}
?>