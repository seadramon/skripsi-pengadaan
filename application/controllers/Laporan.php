<?php 
/**
* 
*/
class Laporan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('insiden_model');
		$this->load->model('laporan_model');
	}

	public function index()
	{

	}

	public function insiden()
	{
		if (strtolower($_SERVER['REQUEST_METHOD'])=='post') {
			$post = purify($this->input->post());
			$param = array('start' => isset($post['start'])?$post['start']:"",
							'end' 		  => isset($post['end'])?$post['end']:"",
							'id_fase' 	  => isset($post['id_fase'])?$post['id_fase']:"",
							'id_kategori' => isset($post['id_kategori'])?$post['id_kategori']:"");
			$insiden = $this->laporan_model->insiden($param);
			$idInsiden = $this->laporan_model->idInsiden($param);
			$arrIdInsiden = array();
			foreach ($idInsiden as $val) {
				$arrIdInsiden[] = $val['id_insiden'];
			}
			
			$kebutuhan = $this->laporan_model->kebutuhan($arrIdInsiden);
			$pos = $this->laporan_model->pos($arrIdInsiden);

			$this->load->library('mpdf/mpdf');
			$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
			$mpdf->SetProtection(array('print'));
			$mpdf->SetAuthor("Damar");
			$data = array('insiden' => $insiden,
					'param' => $param,
					'kebutuhan' => $kebutuhan,
					'pos' => $pos);
			$html = $this->load->view('report/reportInsiden', $data, true);
			$this->mpdf->WriteHTML($html);
			$this->mpdf->Output('Insiden.pdf', 'I');
		}
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$cbKategori = get_combobox("select id_kategori, nama from kategori", "id_kategori", "nama", "-Pilih Kategori-");

		$cbFase = get_combobox("select id_fase, nama from fase", "id_fase", "nama", "-Pilih Fase-");
		$data = array('fase' => $cbFase,
			'kategori' => $cbKategori);
		$this->load->view('report/formInsiden', $data);

		$this->load->view('frontend/layout/footer');
	}

	public function terimaDonasi($id_insiden)
	{
		$bantuan = $this->laporan_model->donasi($id_insiden);

		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("DamarKeren");
		$data = array('donasi' => $bantuan);
		$html = $this->load->view('report/reportDonasi', $data, true);
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output($id_insiden.'_LaporanDonasi.pdf', 'I');
	}

	public function terimaBantuan($id_insiden)
	{
		$bantuan = $this->laporan_model->bantuan($id_insiden);

		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("DamarKeren");
		$data = array('donasi' => $bantuan);
		$html = $this->load->view('report/reportBantuan', $data, true);
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output($id_insiden.'_LaporanBantuan.pdf', 'I');
	}

	public function penyaluran($id_insiden)
	{
		$aktivitas = $this->laporan_model->aktivitas($id_insiden);
		$penyaluran = $this->laporan_model->penyaluran($id_insiden);
		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("DamarKeren");
		$data = array('aktivitas' => $aktivitas,
				'penyaluran' => $penyaluran);
		$html = $this->load->view('report/reportPenyaluran', $data, true);
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output($id_insiden.'_LaporanBantuan.pdf', 'I');
	}

	public function rekap($id_insiden)
	{
		$this->load->model('insiden_model');
		$this->load->model('poslogistik_model');
		$this->load->model('kebutuhan_model');
		$this->load->model('bantuan_model');

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

		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("DamarKeren");
		$html = $this->load->view('report/reportRekap', $data, true);
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output($id_insiden.'_LaporanRekap.pdf', 'I');
	}

	public function history()
	{
		// print_r($this->session->userdata());die();
		if (strtolower($_SERVER['REQUEST_METHOD'])=='post') {
			$post = purify($this->input->post());
			$param = array('start' => isset($post['start'])?$post['start']:"",
							'end' 		  => isset($post['end'])?$post['end']:"",
							'id_tipe' 	  => isset($post['id_tipe'])?$post['id_tipe']:"");
			$fund = array();
			$nonfund = array();

			if ($param['id_tipe']=='fe32f9f4-280c-11e6-9f07-0a0027000000') {
				$fund = $this->laporan_model->historyfund($param);
			} else {
				$nonfund = $this->laporan_model->history($param);
			}
			
			$this->load->library('mpdf/mpdf');
			$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
			$mpdf->SetProtection(array('print'));
			$mpdf->SetAuthor("Damar");
			$data = array('fund' => $fund,
					'nonfund' => $nonfund,
					'param' => $param);
			$html = $this->load->view('report/reportHistory', $data, true);
			$this->mpdf->WriteHTML($html);
			$this->mpdf->Output('History.pdf', 'I');
		}
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$cbTipe = get_combobox("select id_tipe, nama from tipe", "id_tipe", "nama", "-Pilih Tipe-");

		$data = array('tipe' => $cbTipe);
		$this->load->view('report/formHistory', $data);

		$this->load->view('frontend/layout/footer');
	}
}