<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Approvepermintaan extends CI_Controller
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
        $this->path_uri      = admin_folder() . '/approvepermintaan';
        $this->path          = base_url() . admin_folder().'/permintaan';
        $this->title         = get_admin_menu_title('approvepermintaan');
        $this->id_admin_menu = get_admin_menu_id('permintaan');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

	private $arrForm = array('nama',
							'satuan',
                            'status');
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
        $query = $this->permintaan_model->getAll();
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['idminta'];
            $edit_href      = site_url($path_uri . '/lihat/' . $id);
            $edit_status    = site_url($path_uri . '/status/' . $id.'/'.$row['status']);

            $data_array[]   = array(
                'no'                => $no,
                'id'                => $id,
                'nik'               => isset($row['nik'])?$row['nik']:"-",
                'tanggal'           => isset($row['tanggal'])?$row['tanggal']:"-",
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
        $this->parser->parse($template.'appermintaan', $data);
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
        $confirm    = ['' => '-Pilih Konfirmasi-',
            'disetujui' => 'approve',
            'ditolak'   => 'reject'];
        
        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->permintaan_model->getById($id);
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
            $action = site_url($path_uri.'/lihat/'.$id);
        } else {
            $breadcrumbs[] = array(
                'text'  => 'Add',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/add');

            $maxUrut = (int)$this->permintaan_model->maxUrut() + 1;
            $id = sprintf("PM%05d", $maxUrut);
        }

        $action = site_url($path_uri.'/lihat/'.$id);

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        /*FORM HEADER PERMINTAAN*/
        $arrForm = array('idminta',
                        'nik',
        				'deskripsi');
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
                if ($fieldName=='idminta') $post[$fieldName] = $id;
                if ($fieldName=='nik') $post[$fieldName] = $this->session->userdata()['ADM_SESS']['nik'];
	        }
        }

        /*FORM DETAIL PERMINTAAN*/
        $actionDetail = site_url($path_uri.'/addDetail/'.$header);

        if (strlen($iddetail) > 0) {
            $actionDetail = site_url($path_uri.'/editDetail/'.$iddetail);
            $query = $this->detailpermintaan_model->getById($iddetail);

            if ($query->num_rows()>0) {
                $row = $query->row_array();
            }
        }

        $arrFormDetail = array('idbarang',
                        'idminta',
                        'jumlah',
                        'tanggal_pengiriman');
        foreach ($arrFormDetail as $fieldNameDet) {
            // set Error
            if (isset($this->error[$fieldNameDet])) {
                $error_message[$fieldNameDet] = alert_box($this->error[$fieldNameDet], 'error');
            } else {
                $error_message[$fieldNameDet] = '';
            }

            // set value
            if ($this->input->post($fieldNameDet) != '') {
                $postDetail[$fieldNameDet] = $this->input->post($fieldNameDet);
            } elseif (strlen($id)>0 && strlen($iddetail)>0) {
                $postDetail[$fieldNameDet] = $row[$fieldNameDet];
            } else {
                $postDetail[$fieldNameDet] = '';
            }
        }

        /*LIST DETAIL*/
        $query = $this->detailpermintaan_model->getAll($header);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['idminta'].'_'.$row['idbarang'];
            $edit_href      = site_url($path_uri . '/edit/' . $header.'/'.$id);
            $del_href       = site_url($path_uri . '/delete/' . $id);

            $data_array[]   = array(
                'no'                => $no,
                'id'                => $id,
                'namaBrg'           => isset($row['namaBrg'])?$row['namaBrg']:"-",
                'jumlah'            => isset($row['jumlah'])?$row['jumlah']:"-",
                'satuan'            => isset($row['satuan'])?$row['satuan']:"-",
                'tanggal_pengiriman'=> isset($row['tanggal_pengiriman'])?$row['tanggal_pengiriman']:"-",
                'keterangan'        => isset($row['keterangan'])?$row['keterangan']:"-",
                'edit_href'         => $edit_href
            );
        }
        // print_r($data_array);die();

        $post = array($post);
        $postDetail = array($postDetail);
        $error_message = array($error_message);

        //Confirmation header
        $success_msg = alert_box($this->session->flashdata('success_msg'), 'success');
        $failed_msg = alert_box($this->session->flashdata('failed_msg'), 'error');
        $info_msg    = alert_box($this->session->flashdata('info_msg'), 'warning');

        $det_success_msg = alert_box($this->session->flashdata('det_success_msg'), 'success');
        $det_failed_msg = alert_box($this->session->flashdata('det_failed_msg'), 'error');

        $listsuccess_msg = alert_box($this->session->flashdata('listsuccess_msg'), 'success');
        $listfailed_msg = alert_box($this->session->flashdata('listfailed_msg'), 'error');

        $data = array(
            'base_url'    => base_url(),
            'menu_title'  => $menu_title,
            'current_url' => current_url(),
            'post'        => $post,
            'postDetail'  => $postDetail,
            'data'        => $data_array,
            'id'		  => $id,
            'idheader'    => $header,
            'action'      => $action,
            'actionDetail'=> $actionDetail,
            'confirm'     => $confirm,
            'success_msg' => $success_msg,
            'failed_msg'  => $failed_msg,
            'error_msg'   => $error_message,
            'det_success_msg' => $det_success_msg,
            'det_failed_msg' => $det_failed_msg,
            'listsuccess_msg'=>$listsuccess_msg,
            'listfailed_msg' => $listfailed_msg,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse($template . 'appermintaan_form', $data);
        $this->global_libs->print_footer();
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $post['tanggal'] = date('Y-m-d');
            $post['status'] = 'requested';

            $result = $this->permintaan_model->insert($post);

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('failed_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri.'/edit/'.$post['idminta']);
        }
        $this->getForm();
    }

    public function lihat($id = "", $iddetail = "")
    {
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $post = purify($this->input->post());
            $post['tanggal_disetujui'] = date('Y-m-d');
            $status = ['status' => 'disetujui'];

            $result = $this->permintaan_model->update($id, $post);
            $updateDetail = $this->detailpermintaan_model->updateByIdMinta($id, $status);

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been updated');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be updated');
            }

            if ($this->session->userdata('referrer') != '') {
                redirect($this->session->userdata('referrer'));
            } else {
                redirect($this->path_uri);
            }
        }
        $this->getForm($id, $iddetail);
    }

    public function addDetail($idheader = "")
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            if ($idheader!="") {
                $post = purify($this->input->post());
                $maxUrut = (int)$this->detailpermintaan_model->maxUrut() + 1;
                $id = sprintf("DM%05d", $maxUrut);

                $post['iddetail_permintaan'] = $id;
                $post['idminta'] = $idheader;

                $result = $this->detailpermintaan_model->insert($post);

                if ($result==1) {
                    $this->session->set_flashdata('det_success_msg', 'Detail Permintaan berhasil ditambahkan');
                } else {
                    $this->session->set_flashdata('det_failed_msg', 'Detail Permintaan gagal ditambahkan');
                }

                redirect($this->path_uri.'/edit/'.$post['idminta']);
            } else {
                $this->session->set_flashdata('det_failed_msg', 'Anda harus mengisi form permintaan barang terlebih dahulu');
            }
        }
        $this->getForm();
    }

    public function editDetail($id = "")
    {
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id) ) {
            $post = purify($this->input->post());
            $result = $this->detailpermintaan_model->update($id, $post);

            if ($result==1) {
                $this->session->set_flashdata('det_success_msg', 'Detail Permintaan berhasil diubah');
            } else {
                $this->session->set_flashdata('det_failed_msg', 'Detail Permintaan gagal ditambahkan');
            }

            redirect($this->path_uri.'/edit/'.$post['idminta']);
        }
        $this->getForm($id, $iddetail);
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