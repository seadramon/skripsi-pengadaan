<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Perintahbayar extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		auth_admin();
		$this->load->model(admin_folder() . '/permintaan_model');
		$this->load->model(admin_folder() . '/laporan_model');
        $this->load->model(admin_folder() . '/detailpermintaan_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'master/permintaan';
        $this->template      = admin_folder() . '/laporan/';
        $this->path_uri      = admin_folder() . '/laporan/permintaan';
        $this->path          = base_url() . admin_folder().'/permintaan';
        $this->title         = get_admin_menu_title('laporan/permintaan');
        $this->id_admin_menu = get_admin_menu_id('permintaan');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

	public function index()
	{
		$this->global_libs->print_header();

		$data = [];
		$no = 0;
		$start = "";
		$end = "";
		$statusVal = "";
		$errStart = "";
		$errEnd = "";
		$actionCetak = site_url($this->path_uri.'/cetak');
		$status = ['' => '-Pilih Status-',
			'sent' => 'sent',
			'paid' => 'paid',
		];

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = purify($this->input->post());

			if ($post['start']!="" && $post['end']!="") {
				$data = $this->laporan_model->perintahbayar($post['start'], $post['end'], $post['status']);
				$start = $post['start'];
				$end = $post['end'];
				$statusVal = $post['status'];
			} else {
				$errStart = alert_box("Anda harus mengisi tanggal mulai dulu", 'error');
				$errEnd = alert_box("Anda harus mengisi tanggal berakhir dulu", 'error');
			}
		}

		$data = ['status' => $status,
			'data'	=> $data,
			'start' => $start,
			'end' => $end,
			'statusVal' => $statusVal,
			'actionCetak' => $actionCetak,
			'errStart' => $errStart,
			'errEnd' => $errEnd,
			'path_uri' => $this->path_uri
		];
		$this->load->view('admpage/laporan/pembayaran/perintahbayar', $data);
		$this->global_libs->print_footer();

	}

	public function cetak($start, $end, $status = "")
	{
		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("Damar");

		$data = $this->laporan_model->perintahbayarPdf($start, $end, $status);
		$arrData = ['data' => $data,
			'start' => $start,
			'end'	=> $end,
			'status' => $status
		];
		$html = $this->load->view('admpage/laporan/pembayaran/perintahbayarPdf', $arrData, true);

		$filename = "hello";
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output('permintaan.pdf', 'I');
	}
}