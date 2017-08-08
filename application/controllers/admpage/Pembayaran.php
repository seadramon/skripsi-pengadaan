<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class pembayaran extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_admin();
		$this->load->model(admin_folder() . '/pembayaran_model');
        // $this->load->model(admin_folder() . '/detailpembayaran_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'master/pembayaran';
        $this->template      = admin_folder() . '/transaksi/pembayaran/';
        $this->path_uri      = admin_folder() . '/pembayaran';
        $this->path          = base_url() . admin_folder().'/pembayaran';
        $this->title         = get_admin_menu_title('pembayaran');
        $this->id_admin_menu = get_admin_menu_id('pembayaran');

        $this->max_width    = 281;
        $this->max_height   = 392;

        $this->divisi       = $this->session->userdata()['ADM_SESS']['iddivisi'];
	}

	private $arrForm = array('idpo',
							'tanggal_perintahbayar',
                            'jml_bayar',
                            'status');
    private $arrFormBayar = ['tanggal_dibayar', 'status'];
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
        $total_records = $this->pembayaran_model->getTotal($s_name);
        $query = $this->pembayaran_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['idpembayaran'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            $data_array[]   = array(
                'no'                => $no,
                'id'                => $id,
                'idpo'              => isset($row['idpo'])?$row['idpo']:"-",
                'tanggal_perintahbayar'=> isset($row['tanggal_perintahbayar'])?$row['tanggal_perintahbayar']:"-",
                'status'            => isset($row['status'])?$row['status']:"-",
                'edit_href'         => $edit_href
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
            'divisi'      => $this->divisi,
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
        $this->parser->parse($template.'pembayaran', $data);
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
        $cancel_btn = site_url($path_uri);
        $no = 0;
        $status     = ['' => '-Pilih Status-',
                    'sent' => 'sent',
                    'paid' => 'paid',
        ];
        
        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->pembayaran_model->getById($id);
            if ($query->num_rows()>0) {
                $header = $id;
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }
        
        if ($id) {
            $breadcrumbs[] = array(
                'text'  => 'Edit',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/edit/'.$id);
        } else {
            $breadcrumbs[] = array(
                'text'  => 'Add',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/add');

            $maxUrut = auto_inc('pembayaran');
            $id = sprintf("BY%05d", $maxUrut);
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        /*FORM HEADER po*/
        $arrForm = array('idpembayaran',
                        'idpo',
                        'tanggal_perintahbayar',
                        'tanggal_dibayar',
                        'jml_bayar',
        				'status');
        foreach ($arrForm as $fieldName) {
        	// set Error
        	if (isset($this->error[$fieldName])) {
            	$error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        } else {
	            $error_message[$fieldName] = '';
	        }

	        // set value
	        if ($this->input->post($fieldName) != '') {
	            $post[$fieldName] = $this->input->post($fieldName);
	        } elseif (strlen($id)>0 && strlen($header)>0) {
	            $post[$fieldName] = $row[$fieldName];
	        } else {
	            $post[$fieldName] = '';
                if ($fieldName=='idpembayaran') $post[$fieldName] = $id;
	        }
        }

        $post = array($post);
        $postDetail = array($postDetail);
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
            'postDetail'  => $postDetail,
            // 'data'        => $data_array,
            'status'      => $status,
            'id'		  => $id,
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
        if ($this->divisi=='D02') {
            $this->parser->parse($template . 'updatepembayaran_form', $data);
        } else {
            $this->parser->parse($template . 'pembayaran_form', $data);
        }
        $this->global_libs->print_footer();
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $result = $this->pembayaran_model->insert($post);

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('failed_msg', $this->title . ' cannot be added');
            }
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
            $result = $this->pembayaran_model->update($id, $post);

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been updated');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be updated');
            }
            redirect($this->path_uri);
        }
        $this->getForm($id, $iddetail);
    }

    private function validateForm()
    {
        $post = purify($this->input->post());

        if ($this->divisi=='D02') {
            foreach ($this->arrFormBayar as $fieldName) {
                if ($post[$fieldName]=='') {
                    $this->error[$fieldName] = $fieldName.' Cannot be empty';    
                } else {
                    if ($fieldName=='jumlah') {
                        if (!ctype_digit($post[$fieldName])) {
                            $this->error[$fieldName] = $fieldName.' harus dalam bentuk angka';
                        }
                    }
                }
            }    
        } else {
            foreach ($this->arrForm as $fieldName) {
                if ($post[$fieldName]=='') {
                    $this->error[$fieldName] = $fieldName.' Cannot be empty';    
                } else {
                    if ($fieldName=='jml_bayar') {
                        if (!ctype_digit($post[$fieldName])) {
                            $this->error[$fieldName] = $fieldName.' harus dalam bentuk angka';
                        }
                    }
                }
            }
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
                    if ($this->detailpembayaran_model->delete($id)) {
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