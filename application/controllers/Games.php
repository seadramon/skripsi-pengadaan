<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Games extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('participation_model');
	}

	public function index()
	{
		if ($this->session->userdata('userConnected')['userId']!="") {
			$this->load->view('frontend/games');
		} else {
			$this->load->view('frontend/home');			
		}
	}
	
	public function submit()
	{
		/*print_r($this->session->userdata('spgConnected'));
		print_r($this->session->userdata('userConnected'));*/
		$userId = $this->session->userdata('userConnected')['userId'];
		$varPrize = isset($_POST['prize'])?$_POST['prize']:"";
		switch (strtolower($varPrize)) {
			case 'gift b':
				$prize = '1';
				break;
			case 'gift a';
				$prize = '2';
				break;
			case 'super gift';
				$prize = '3';
				break;
			case 'kosong';
				$prize = '4';
				break;
		}
		// 
		$mall = $this->session->userdata('spgConnected')['mallId'];
		$data = array('datetime' => date('Y-m-d H:i:s'),
					  'user_id' => $userId,
					  'prize_id' => !is_null($prize)?$prize:"",
					  'mall_id' => !is_null($mall)?$mall:"",
					  'status' => '1');
		$insert = $this->participation_model->insert($data);
		if ($insert) {
			header("Location:".base_url().'thankyou/index/'.$varPrize);
		} else {
			header("Location:".base_url().'games');
		}	
	}
}
?>
