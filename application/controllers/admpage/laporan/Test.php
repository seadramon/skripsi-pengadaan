<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Test extends CI_Controller
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
				$data = $this->laporan_model->test($post['start'], $post['end']);
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
		$this->load->view('admpage/laporan/mki/test', $data);
		$this->global_libs->print_footer();
	}

	public function cetak($start = "", $end = "")
	{
		$start = "2016-12-01";
		$end = "2017-01-31";

		$this->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8','A4-L','','','5','5','5','5','5','5','L'); 
		$mpdf->SetProtection(array('print'));
		$mpdf->SetAuthor("Damar");

		$dataHead = '[{"idpo":"PO00001","total":"600000","tanggal":"2016-12-27","supplier":"PT. Maju Jaya Terus"},{"idpo":"PO00002","total":"5000","tanggal":"2017-01-03","supplier":"Snasjn"},{"idpo":"PO00003","total":"3296","tanggal":"2017-01-03","supplier":"Media Kreasi Inov"},{"idpo":"PO00004","total":"2000","tanggal":"2017-01-03","supplier":"Dia Supplier"},{"idpo":"PO00005","total":"14000","tanggal":"2017-01-03","supplier":"Budi"},{"idpo":"PO00006","total":"6000","tanggal":"2017-01-03","supplier":"Luhur"},{"idpo":"PO00007","total":"125000","tanggal":"2017-01-03","supplier":"Budi"},{"idpo":"PO00008","total":"200","tanggal":"2017-01-03","supplier":"Luhur"},{"idpo":"PO00009","total":"1100","tanggal":"2017-01-05","supplier":"Media Kreasi Inov"}]';
		$arrHead = json_decode($dataHead, true);
		
		$data = '[{"idpo":"PO00001","idpoDetail":"PO00001","barang":"Triton Cf-10","idbarang":"BG0007","tanggal_pengiriman":"2016-12-30","jumlah":"200","harga_satuan":"1000","jumlah_harga":"200000","supplier":"PT. Maju Jaya Terus","tanggal":"2016-12-27","total":"600000"},{"idpo":"PO00001","idpoDetail":"PO00001","barang":"Octoate","idbarang":"BG0008","tanggal_pengiriman":"2016-12-30","jumlah":"200","harga_satuan":"2000","jumlah_harga":"400000","supplier":"PT. Maju Jaya Terus","tanggal":"2016-12-27","total":"600000"},{"idpo":"PO00002","idpoDetail":"PO00002","barang":"Tawas Vip","idbarang":"BG0001","tanggal_pengiriman":"2017-01-17","jumlah":"2","harga_satuan":"1000","jumlah_harga":"2000","supplier":"Snasjn","tanggal":"2017-01-03","total":"5000"},{"idpo":"PO00002","idpoDetail":"PO00002","barang":"Acrysol Rm 2020npr","idbarang":"BG0006","tanggal_pengiriman":"2017-01-09","jumlah":"1","harga_satuan":"3000","jumlah_harga":"3000","supplier":"Snasjn","tanggal":"2017-01-03","total":"5000"},{"idpo":"PO00003","idpoDetail":"PO00003","barang":"Octoate 50%","idbarang":"BG0009","tanggal_pengiriman":"2017-01-12","jumlah":"70","harga_satuan":"30","jumlah_harga":"2100","supplier":"Media Kreasi Inov","tanggal":"2017-01-03","total":"3296"},{"idpo":"PO00003","idpoDetail":"PO00003","barang":"Gas LPG 30","idbarang":"BG0010","tanggal_pengiriman":"2017-01-12","jumlah":"40","harga_satuan":"30","jumlah_harga":"1196","supplier":"Media Kreasi Inov","tanggal":"2017-01-03","total":"3296"},{"idpo":"PO00004","idpoDetail":"PO00004","barang":"Barang Tes","idbarang":"BG0002","tanggal_pengiriman":"2017-01-13","jumlah":"20","harga_satuan":"30","jumlah_harga":"500","supplier":"Dia Supplier","tanggal":"2017-01-03","total":"2000"},{"idpo":"PO00004","idpoDetail":"PO00004","barang":"Triton Cf-10","idbarang":"BG0007","tanggal_pengiriman":"2017-01-12","jumlah":"30","harga_satuan":"50","jumlah_harga":"1500","supplier":"Dia Supplier","tanggal":"2017-01-03","total":"2000"},{"idpo":"PO00005","idpoDetail":"PO00005","barang":"Buku","idbarang":"BG0015","tanggal_pengiriman":"2017-01-20","jumlah":"20","harga_satuan":"2000","jumlah_harga":"4000","supplier":"Budi","tanggal":"2017-01-03","total":"14000"},{"idpo":"PO00005","idpoDetail":"PO00005","barang":"Pulpen","idbarang":"BG0016","tanggal_pengiriman":"2017-01-14","jumlah":"10","harga_satuan":"1000","jumlah_harga":"10000","supplier":"Budi","tanggal":"2017-01-03","total":"14000"},{"idpo":"PO00006","idpoDetail":"PO00006","barang":"Pulpen","idbarang":"BG0016","tanggal_pengiriman":"2017-01-20","jumlah":"20","harga_satuan":"3000","jumlah_harga":"6000","supplier":"Luhur","tanggal":"2017-01-03","total":"6000"},{"idpo":"PO00007","idpoDetail":"PO00007","barang":"Acrysol Rm 2020npr","idbarang":"BG0006","tanggal_pengiriman":"2017-01-20","jumlah":"25","harga_satuan":"2000","jumlah_harga":"50000","supplier":"Budi","tanggal":"2017-01-03","total":"125000"},{"idpo":"PO00007","idpoDetail":"PO00007","barang":"Triton Cf-10","idbarang":"BG0007","tanggal_pengiriman":"2017-01-20","jumlah":"30","harga_satuan":"35000","jumlah_harga":"75000","supplier":"Budi","tanggal":"2017-01-03","total":"125000"},{"idpo":"PO00008","idpoDetail":"PO00008","barang":"Acrysol Rm 2020npr","idbarang":"BG0006","tanggal_pengiriman":"2017-01-27","jumlah":"10","harga_satuan":"20","jumlah_harga":"200","supplier":"Luhur","tanggal":"2017-01-03","total":"200"},{"idpo":"PO00009","idpoDetail":"PO00009","barang":"Acrysol Rm 2020npr","idbarang":"BG0006","tanggal_pengiriman":"2017-01-06","jumlah":"10","harga_satuan":"30","jumlah_harga":"300","supplier":"Media Kreasi Inov","tanggal":"2017-01-05","total":"1100"},{"idpo":"PO00009","idpoDetail":"PO00009","barang":"Octoate","idbarang":"BG0008","tanggal_pengiriman":"2017-01-07","jumlah":"20","harga_satuan":"40","jumlah_harga":"800","supplier":"Media Kreasi Inov","tanggal":"2017-01-05","total":"1100"}]';
		$arrData = json_decode($data);
		$arrData = ['dataHead' => $arrHead,
			'data' => $arrData,
			'start' => $start,
			'end'	=> $end,
		];
		$html = $this->load->view('admpage/laporan/mki/testPdf', $arrData, true);

		$filename = "hello";
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output('po.pdf', 'I');
	}
}