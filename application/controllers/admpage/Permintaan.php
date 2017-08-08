<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Permintaan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_admin();
		$this->load->model(admin_folder() . '/permintaan_model');
        $this->load->model(admin_folder() . '/detailpermintaan_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'master/permintaan';
        $this->template      = admin_folder() . '/transaksi/permintaan/';
        $this->path_uri      = admin_folder() . '/permintaan';
        $this->path          = base_url() . admin_folder().'/permintaan';
        $this->title         = get_admin_menu_title('permintaan');
        $this->id_admin_menu = get_admin_menu_id('permintaan');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

	private $arrForm = array('idbarang',
                            'jumlah',
                            'tanggal_pengiriman',);
    private $error;

	public function index()
	{
		$this->main();
	}

	function main()
	{
		$this->session->set_userdata('referrer', current_url());
        $this->global_libs->print_header();

        $s_name		 = $this->uri->segment(5);
        $pg 		 = $this->uri->segment(6);
        $per_page 	 = 10;
        $uri_segment = 6;
        $no		 	 = 0;
        $path		 = $this->path.'/main/a/';
        $data_array  = array();
        $credit_array = array();
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
        $total_records = $this->permintaan_model->getTotal($s_name);
        // $query = $this->permintaan_model->getAll($s_name, $per_page, $lmt);
        $query = $this->permintaan_model->getAll();
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['idminta'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);
            $edit_status    = site_url($path_uri . '/status/' . $id.'/'.$row['status']);

            $data_array[]   = array(
                'no'                => $no,
                'id'                => $id,
                'nik'               => isset($row['nik'])?$row['nik']:"-",
                'tanggal_disetujui' => isset($row['tanggal_disetujui'])?$row['tanggal_disetujui']:"-",
                'status'            => isset($row['status'])?$row['status']:"-",
                'edit_href'         => $edit_href,
                'edit_status'       => $edit_status
            );
        }

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
        $this->parser->parse($template.'permintaan', $data);
        $this->global_libs->print_footer();
	}

	public function getForm($id = "", $iddetail = "")
    {
        /*HEADER AND DECLARATION*/
        $this->global_libs->print_header();
        $this->session->set_userdata('referrer', current_url());

        $header = "";
        $listDetail = array();

        $menu_title	= $this->title;
        $file_app	= $this->ctrl;
        $path_app	= $this->path;
        $path_uri	= $this->path_uri;
        $template	= $this->template;
        $maxUrut    =  0;
        $error_message	= array();
        $post		= array();
        $postDetail = array();
        $data_array = array();
        $image      = "";
        $status     = "";
        $cancel_btn = site_url($path_uri);
        $row        = array();
        $no = 0;
        $mode       = "add";
        
        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->permintaan_model->getByIdAll($id);
            if ($query->num_rows()>0) {
                $row = $query->result_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }

        if ($id) {
            $breadcrumbs[] = array(
                'text'  => 'Edit',
                'href'  => current_url().'#',
                'class' => 'class="current"'
            );
            $action = site_url($path_uri.'/edit/'.$id);
            $mode = "edit";
        } else {
            $breadcrumbs[] = array(
                'text'  => 'Add',
                'href'  => current_url().'#',
                'class' => 'class="current"'
            );
            $action = site_url($path_uri.'/add');

            $maxUrut = auto_inc('permintaan');
            $id = sprintf("PM%05d", $maxUrut);

            $mode = "add";
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        /*FORM HEADER PERMINTAAN*/
        $arrForm = array('idminta',
                        'nik',
        				'deskripsi',
                        'idbarang',
                        'idminta',
                        'jumlah',
                        'tanggal_pengiriman');
        foreach ($arrForm as $fieldName) {
        	// set Error
        	if (isset($this->error[$fieldName])) {
            	$error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        } else {
	            $error_message[$fieldName] = '';
	        }
        }

        // dd($row);
        if (count($row) > 0) $post = $row;
        $error_message = array($error_message);

        //Confirmation header
        $success_msg = alert_box($this->session->flashdata('success_msg'), 'success');
        $failed_msg = alert_box($this->session->flashdata('failed_msg'), 'error');
        $info_msg    = alert_box($this->session->flashdata('info_msg'), 'warning');

        $data = array(
            'base_url'    => base_url(),
            'menu_title'  => $menu_title,
            'current_url' => current_url(),
            'post'        => $post,
            'data'        => $data_array,
            'id'		  => $id,
            'mode'        => $mode,
            'nik'         => $this->session->userdata()['ADM_SESS']['nik'],
            'action'      => $action,
            'success_msg' => $success_msg,
            'failed_msg'  => $failed_msg,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse($template . 'permintaan_form', $data);
        $this->global_libs->print_footer();
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            unset($post['idbarang_Clone']);

            $arrHeader = $this->getheader($post);
            $arrHeader['tanggal'] = date('Y-m-d');
            $arrHeader['status'] = 'requested';
            $result = $this->permintaan_model->insert($arrHeader);
            $arrDetail = $this->getdetail($post);

            if ($result==1) {
                $resultD = $this->permintaan_model->insertDetail($arrDetail['dpermintaan']);
            }

            if ($resultD==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('failed_msg', $this->title . ' cannot be added');
            }

            // redirect($this->path_uri.'/edit/'.$post['idminta']);
            redirect($this->path_uri);
        }
        $this->getForm();
    }

    public function edit($id = "", $iddetail = "")
    {
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id) ) {
            $post = purify($this->input->post());
            unset($post['idbarang_Clone']);

            $arrHeader = $this->getheader($post);
            $arrHeader['tanggal'] = date('Y-m-d');
            $arrHeader['status'] = 'requested';
            $result = $this->permintaan_model->update($id, $arrHeader);
            $arrDetail = $this->getdetail($post);

            $clear = $this->permintaan_model->clearDetail($id);
            if ($result==1) {
                $resultD = $this->permintaan_model->insertDetail($arrDetail['dpermintaan']);
            }

            if ($resultD==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been updated');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be updated');
            }
            
            redirect($this->path_uri);
        }
        $this->getForm($id, $iddetail);
    }

    private function getheader($post = array())
    {
        $i = 0;
        $jml = count($post['dpermintaan']);
        for ($i=0; $i < $jml ; $i++) { 
            unset($post['idbarang_'.$i]);
        }

        unset($post['jumlah']);
        unset($post['tanggal_pengiriman']);
        unset($post['keterangan']);
        unset($post['dpermintaan']);

        return $post;
    }

    private function getdetail($post = array())
    {
        if (is_array($post['dpermintaan']) && count($post['dpermintaan']) > 0) {
            $jml = count($post['dpermintaan']);
            for ($i=0; $i < $jml; $i++) { 
                $post['dpermintaan'][$i]['idbarang'] = $post['idbarang_'.$i];
                $post['dpermintaan'][$i]['idminta'] = $post['idminta'];
                $post['dpermintaan'][$i]['status'] = 'requested';
            }

            foreach ($post as $key => $value) {
                if ($key!='dpermintaan') {
                    unset($post[$key]);
                }
            }
        }
        return $post;
    }

    private function validateForm()
    {
        $post = purify($this->input->post());
        $jmlDetail = count($post['dpermintaan']);
        if ($jmlDetail > 1) {
            for ($i=0; $i < $jmlDetail; $i++) { 
                foreach ($this->arrForm as $fieldName) {
                    if (substr($fieldName, 0, 8)=='idbarang') {
                        if ($post[$fieldName.'_'.$i]=='') {
                            $this->error['idbarang'] = "Anda belum memilih barang";
                        }
                    }

                    if ($fieldName!='idbarang') {
                        if ($post['dpermintaan'][$i][$fieldName]=='') {
                            $this->error[$fieldName] = $fieldName.' Cannot be empty';    
                        } else {
                            if ($fieldName=='jumlah') {
                                if (!ctype_digit($post['dpermintaan'][$i][$fieldName])) {
                                    $this->error[$fieldName] = $fieldName.' harus dalam bentuk angka';
                                }
                            }

                            /*Cek detail exist*/
                            $jml = validateDetail('detail_permintaan', 'idminta', $post['dpermintaan'][$i]['idbarang'], $post['idminta']);
                            if ($jml > 1) $this->error['idbarang'] = "Detail barang ada yang sudah pernah diinputkan";
                        }
                    }
                }
            }
        } else {
            $this->error['idbarang'] = "Anda belum mengisi detail permintaan";
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if (strlen($this->input->post('id')) > 0) {
                    $id = $this->input->post('id');
                    if ($this->detailpermintaan_model->delete($id)) {
                        $this->session->set_flashdata('listsuccess_msg', 'Detail has been deleted.');
                    } else {
                        $this->session->set_flashdata('listfailed_msg', 'Delete failed. Please try again.[DB]');
                    }
            } else {
                $this->session->set_flashdata('listfailed_msg', 'Delete failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('listfailed_msg', 'Delete failed. Please try again.');
        }
    }
}