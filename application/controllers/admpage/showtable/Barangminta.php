<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Barangminta extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		auth_admin();
		$this->load->model(admin_folder() . '/barang_model');
        $this->load->model(admin_folder() . '/detailpermintaan_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'showtable/barangminta';
        $this->template      = admin_folder() . '/showtable/';
        $this->path_uri      = admin_folder() . '/showtable/barangminta';
        $this->path          = base_url() . admin_folder().'/showtable/barangminta';
        $this->title         = get_admin_menu_title('barang');
        $this->id_admin_menu = get_admin_menu_id('barang');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

    private $arrForm = array('idbarang',
                         'description',
                         'contact_person',
                         'account_id');
    private $error;

	public function index($idAttr = "", $idminta = "")
	{
		$this->main($idAttr, $idminta);
	}

	function main($idAttr = "", $idminta = "")
	{
		$this->session->set_userdata('referrer', current_url());
        // $this->global_libs->print_header();

        $s_name		 = $this->uri->segment(6);
        $pg 		 = $this->uri->segment(7);
        $per_page 	 = 10;
        $uri_segment = 6;
        $no		 	 = 0;
        $path		 = $this->path.'/main/a/';
        $data_array  = array();
        $menu_title	 = $this->title;
        $file_app	 = $this->ctrl;
        $path_uri	 = $this->path_uri;
        $path_app	 = $this->path;
        $template	 = $this->template;
        $add_btn     = site_url($path_uri . '/add');
        $breadcrumbs = $this->global_libs->getBreadcrumbs($file_app);
        
        $breadcrumbs[] = array(
                'text'  => $menu_title,
                'href'  => '#',
                'class' => 'class="current"'
        );

        if (strlen($s_name) > 1) {
            $s_name = substr($s_name, 1);
        } else {
            $s_name = '';
        }

        if ($s_name) {
            $path = str_replace('/a/', '/a' . $s_name . '/', $path);
        }

        if (!$pg) {
            $lmt = 0;
            $pg = 1;
        } else {
            $lmt = $pg;
        }
        $no = $lmt;
        $total_records = 0;
        if ($idminta!="") {
            $query = $this->detailpermintaan_model->getAll($idminta);
            foreach ($query->result_array() as $row) {
                $no++;
                $id             = $row['idbarang'];
                $edit_href      = site_url($path_uri . '/edit/' . $id);

                $a = explode('-', $idAttr);
                $brgAttr = $a[0];
                $jmlAttr = $a[1];

                $data_array[]   = array(
                    'no'             => $no,
                    'id'             => $id,
                    'nama'           => isset($row['namaBrg'])?$row['namaBrg']:"-",
                    'satuan'         => isset($row['satuan'])?$row['satuan']:"-",
                    'jumlah'         => isset($row['jumlah'])?$row['jumlah']:"-",
                    'status'         => isset($row['status'])?$row['status']:"-",
                    'brgAttr'        => $brgAttr,
                    'jmlAttr'        => $jmlAttr,
                    'edit_href'      => $edit_href);
            }
        } else {
            $this->session->set_flashdata('info_msg', 'Data Kosong karena ID Permintaan belum dipilih');
        }

        // paging
        $paging = global_paging($total_records, $per_page, $path, $uri_segment);
        if(!$paging) $paging = '<ul class="pagination pagination-sm no-margin pull-left"><li class="active"><a>1</a></li></ul>';
        //end of paging

        $error_message 	 = alert_box($this->session->flashdata('error_msg'), 'error');
        $success_msg = alert_box($this->session->flashdata('success_msg'), 'success');
        $info_msg 	 = alert_box($this->session->flashdata('info_msg'), 'warning');

        $data = array(
            'base_url'    => base_url(),
            'current_url' => current_url(),
            'menu_title'  => $menu_title,
            's_name'      => $s_name,
            'data'        => $data_array,
            'breadcrumbs' => $breadcrumbs,
            'pagination'  => $paging,
            'error_msg'   => $error_message,
            'success_msg' => $success_msg,
            'info_msg'    => $info_msg,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'add_btn'     => $add_btn,
        );
        $this->parser->parse($template.'barangminta', $data);
	}
}
?>