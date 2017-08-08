<?php 
/**
* 
*/
class Pantauinsiden extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->model('insiden_model');
		$this->load->model('poslogistik_model');
		$this->load->model('kebutuhan_model');
		$this->load->model('bantuan_model');
	}

	public function index()
	{

	}

	public function detail($id_insiden)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$insiden = $this->insiden_model->showById($id_insiden)->row_array();
		$pos = $this->poslogistik_model->showByInsiden($id_insiden);

		$kebutuhan = $this->kebutuhan_model->jmlPerTipe($id_insiden);
		$bantuan = $this->bantuan_model->jmlPerTipe($id_insiden);

		$tipeKebutuhan = $this->kebutuhan_model->getTipeKebutuhan($insiden['id_insiden']);
        $bantuanTerkumpulDrop = $this->bantuan_model->getBantuanTerkumpulDrop($insiden['id_insiden']);
        $danaTerkumpul = $this->bantuan_model->jmlPerDana($id_insiden);

		// print_r($insiden);die();

		$data = array('insiden' => $insiden,
					'pos' => $pos,
					'tipeKebutuhan' => $tipeKebutuhan,
					'bantuanTerkumpulDrop' => $bantuanTerkumpulDrop,
					'danaTerkumpul' => $danaTerkumpul);

		$this->load->view('frontend/pantauinsiden/home', $data);

		$this->load->view('frontend/layout/footer');
	}
}
?>