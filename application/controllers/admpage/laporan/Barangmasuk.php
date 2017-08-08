<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Barangmasuk extends CI_Controller
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
		$errStart = "";
		$errEnd = "";
		$actionCetak = site_url($this->path_uri.'/cetak');

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = purify($this->input->post());

			if ($post['start']!="" && $post['end']!="") {
				$data = $this->laporan_model->barangmasuk($post['start'], $post['end']);
				$start = $post['start'];
				$end = $post['end'];
			} else {
				$errStart = alert_box("Anda harus mengisi tanggal mulai dulu", 'error');
				$errEnd = alert_box("Anda harus mengisi tanggal berakhir dulu", 'error');
			}
		}

		$data = ['data'	=> $data,
			'start' => $start,
			'end' => $end,
			'actionCetak' => $actionCetak,
			'errStart' => $errStart,
			'errEnd' => $errEnd,
			'path_uri' => $this->path_uri
		];
		$this->load->view('admpage/laporan/barangmasuk/barangmasuk', $data);
		$this->global_libs->print_footer();

	}

	public function cetak($start, $end)
	{
		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("Damar");

		$data = $this->laporan_model->barangmasukPdf($start, $end);
		$arrData = ['data' => $data,
			'start' => $start,
			'end'	=> $end
		];
		$html = $this->load->view('admpage/laporan/barangmasuk/barangmasukPdf', $arrData, true);

		$filename = "hello";
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output('permintaan.pdf', 'I');
	}
}