<?php 
/**
* 
*/
class Aturbantuan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_user();

		$this->path          = base_url() . 'aturbantuan';
		$this->path_uri      = 'aturbantuan';
		$this->ctrl          = 'aturbantuan';
		$this->load->model('bantuan_model');
	}

	public function index($idtipe = "")
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$this->main($idtipe);

		$this->load->view('frontend/layout/footer');
	}

	public function main($idtipe = "")
	{
		$this->session->set_userdata('referrer', current_url());

		$s_name		 = $this->uri->segment(5);
        $pg 		 = $this->uri->segment(6);
        $per_page 	 = 10;
        $uri_segment = 6;
        $no		 	 = 0;
        $path		 = $this->path.'/main/a/';
        $path_uri	 = $this->path_uri;
        $data_array  = array();
        $file_app	 = $this->ctrl;
        $path_app    = $this->path;
        $add_btn     = site_url($path_uri . '/add');
        
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
        $total_records = $this->bantuan_model->getTotal($idtipe, $s_name);
        $query = $this->bantuan_model->getAll($idtipe, $s_name, $per_page, $lmt);

        $dataId = $query->result_array();
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
            's_name'      => $s_name,
            'data'        => $data_array,
            'pagination'  => $paging,
            'error_msg'   => $error_message,
            'success_msg' => $success_msg,
            'info_msg'    => $info_msg,
            'path_uri'    => $path_uri,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'add_btn'     => $add_btn,
        );
        $this->parser->parse('frontend/aturbantuan/list', $data);
	}
}
?>