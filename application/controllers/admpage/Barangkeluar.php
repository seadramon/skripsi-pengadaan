<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Barangkeluar extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_admin();
		$this->load->model(admin_folder() . '/barangkeluar_model');
        $this->load->model(admin_folder() . '/detailbarangkeluar_model');
        $this->load->model(admin_folder() . '/detailpermintaan_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'master/barangkeluar';
        $this->template      = admin_folder() . '/transaksi/barangkeluar/';
        $this->path_uri      = admin_folder() . '/barangkeluar';
        $this->path          = base_url() . admin_folder().'/barangkeluar';
        $this->title         = get_admin_menu_title('barangkeluar');
        $this->id_admin_menu = get_admin_menu_id('barangkeluar');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

	private $arrForm = array('idminta',
							'tanggal',
                            'idbarang', 'jumlah');
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
        $total_records = $this->barangkeluar_model->getTotal($s_name);
        $query = $this->barangkeluar_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['idbarangkeluar'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            $data_array[]   = array(
                'no'                => $no,
                'id'                => $id,
                'idminta'           => isset($row['idminta'])?$row['idminta']:"-",
                'tanggal'           => isset($row['tanggal'])?$row['tanggal']:"-",
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
        $this->parser->parse($template.'barangkeluar', $data);
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
        $idminta    = "";
        $cancel_btn = site_url($path_uri);
        $no = 0;
        $mode       = "add";
        $row        = array();
        
        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->barangkeluar_model->getByIdAll($id);
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
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/edit/'.$id);

            $mode = "edit";
        } else {
            $breadcrumbs[] = array(
                'text'  => 'Add',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/add');

            $maxUrut = auto_inc('barangkeluar');
            $id = sprintf("BK%05d", $maxUrut);

            $mode = "add";
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        /*FORM HEADER barangkeluar*/
        $arrForm = array('idbarangkeluar',
                        'idminta',
                        'tanggal',
        				'keterangan',
                        'idbarang', 'jumlah');
        foreach ($arrForm as $fieldName) {
        	// set Error
        	if (isset($this->error[$fieldName])) {
            	$error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        } else {
	            $error_message[$fieldName] = '';
	        }
        }
        $post = $row;
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
            'action'      => $action,
            'mode'        => $mode,
            'success_msg' => $success_msg,
            'failed_msg'  => $failed_msg,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse($template . 'barangkeluar_form', $data);
        $this->global_libs->print_footer();
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);
            $arrHeader = $this->getheader($post);
            $result = $this->barangkeluar_model->insert($arrHeader);

            $arrDetail = $this->getdetail($post);
            if ($result==1) {
                $resultD = $this->barangkeluar_model->insertDetail($arrDetail['dbarangkeluar']);
                foreach ($arrDetail['dbarangkeluar'] as $row) {
                    $this->updateStatusDetailMinta($arrHeader['idminta'], $row['idbarang']);
                }
            }

            if ($resultD==1) {
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
            $this->replacer($post);
            $arrHeader = $this->getheader($post);
            $result = $this->barangkeluar_model->update($id, $arrHeader);

            $arrDetail = $this->getdetail($post);
            $clear = $this->barangkeluar_model->clearDetail($id);
            if ($result==1) {
                $resultD = $this->barangkeluar_model->insertDetail($arrDetail['dbarangkeluar']);
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
        unset($post['dbarangkeluar']);

        return $post;
    }

    private function getdetail($post = array())
    {
        if (is_array($post['dbarangkeluar']) && count($post['dbarangkeluar']) > 0) {
            $jml = count($post['dbarangkeluar']);
            for ($i=0; $i < $jml; $i++) { 
                $post['dbarangkeluar'][$i]['idbarangkeluar'] = $post['idbarangkeluar'];
                unset($post['dbarangkeluar'][$i]['jumlahhide']);
            }

            foreach ($post as $key => $value) {
                if ($key!='dbarangkeluar') {
                    unset($post[$key]);
                }
            }
        }
        return $post;
    }

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            unset($post['idbarang']);
            unset($post['jumlahhide']);
            unset($post['jumlah']);
        }
    }

    private function validateForm()
    {
        $post = purify($this->input->post());
        $jmlDetail = count($post['dbarangkeluar']);
        $arrJml = ['jumlah'];
        $arrExcept = ['idbarang', 'jumlah', 'jumlahhide'];
        $this->replacer($post);
// dd($post);
        if ($jmlDetail > 0) {
            for ($i=0; $i < $jmlDetail; $i++) { 
                foreach ($this->arrForm as $fieldName) {
                    /*Validasi Header*/
                    foreach ($this->arrForm as $fieldName) {
                        if (!in_array($fieldName, $arrExcept)) {
                            if ($post[$fieldName]=='') {
                                $this->error[$fieldName] = $fieldName.' Cannot be empty';    
                            }
                        }
                    }

                    /*Validasi Detail*/
                    if ($post['dbarangkeluar'][$i][$fieldName]=='') {
                        $this->error[$fieldName] = $fieldName.' Cannot be empty';    
                    } else {
                        if ($fieldName=='jumlah') {
                            if (!ctype_digit($post['dbarangkeluar'][$i][$fieldName])) {
                                $this->error[$fieldName] = $fieldName.' harus dalam bentuk angka';
                            } else {
                                if ($post['dbarangkeluar'][$i][$fieldName] > $post['dbarangkeluar'][$i]['jumlahhide']) {
                                    $this->error[$fieldName] = $fieldName.' tidak boleh lebih dari jumlah order pembelian';
                                }
                            }
                        }

                        /*Cek detail exist*/
                        $jml = validateDetail('detail_barangkeluar', 'idbarangkeluar', $post['dbarangkeluar'][$i]['idbarang'], $post['idbarangkeluar']);
                        if ($jml > 1) $this->error['idbarang'] = "Detail barang ada yang sudah pernah diinputkan";
                    }
                }
            }
        } else {
            $this->error['idbarang'] = "Anda belum mengisi detail dbarangkeluar";
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateFormDetail()
    {
        $post = purify($this->input->post());
        foreach ($this->arrFormDetail as $fieldName) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldName.' Cannot be empty';    
            } else {
                if ($fieldName=='jumlah') {
                    if (!ctype_digit($post[$fieldName])) {
                        $this->error[$fieldName] = $fieldName.' harus dalam bentuk angka';
                    } else {
                        if ($post[$fieldName] > $post['jml_minta']) {
                            $this->error[$fieldName] = $fieldName.' tidak boleh lebih dari jumlah permintaan';
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

    public function addDetail($idheader = "")
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateFormDetail()) {
            if ($idheader!="") {
                $post = purify($this->input->post());
                $post['idbarangkeluar'] = $idheader;
                $idminta = $post['idminta'];

                unset($post['jml_minta']);
                unset($post['idminta']);

                $result = $this->detailbarangkeluar_model->insert($post);
                $this->updateStatusDetailMinta($idminta, $post['idbarang']);

                if ($result==1) {
                    $this->session->set_flashdata('det_success_msg', 'Detail barangkeluar berhasil ditambahkan');
                } else {
                    $this->session->set_flashdata('det_failed_msg', 'Detail barangkeluar gagal ditambahkan');
                }

                redirect($this->path_uri.'/edit/'.$post['idbarangkeluar']);
            } else {
                $this->session->set_flashdata('det_failed_msg', 'Anda harus mengisi form barangkeluar barang terlebih dahulu');
                redirect($this->path_uri.'/add/');
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
            unset($post['jml_minta']);
            $result = $this->detailbarangkeluar_model->update($id, $post);

            if ($result==1) {
                $this->session->set_flashdata('det_success_msg', 'Detail barangkeluar berhasil diubah');
            } else {
                $this->session->set_flashdata('det_failed_msg', 'Detail barangkeluar gagal ditambahkan');
            }

            redirect($this->path_uri.'/edit/'.$post['idminta']);
        }
        $this->getForm($id, $iddetail);
    }

    private function updateStatusDetailMinta($idminta, $idbarang)
    {
        $ret = false;
        try {
            $arrData = ['status' => 'used'];
            $id = $idminta.'_'.$idbarang;
            $ret = $this->detailpermintaan_model->update($id, $arrData);
        } catch (Exception $e) {
            dd($e->error);
        }   

        return $ret;
    }

    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if (strlen($this->input->post('id')) > 0) {
                    $id = $this->input->post('id');
                    if ($this->detailbarangkeluar_model->delete($id)) {
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