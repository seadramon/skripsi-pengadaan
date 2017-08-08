<?php 
/**
* 
*/
class Pdftest extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		//$mpdf->useOnlyCoreFonts = true;
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("Damar");
		//$mpdf->SetDisplayMode('fullpage');
		//$mpdf->SetFooter('Document Title');
		// $arrReport = $this->bantuan_model->getReport();
		$data = array('report' => 'arrReport',
				'report2' => 'arrReport2',
				'report3' => 'arrReport3');
		$html = $this->load->view('frontend/report/testpdf', $data, true);
		$filename = "hello";
		//print_r($filename);die();
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output('Insiden.pdf', 'I');
	}
}