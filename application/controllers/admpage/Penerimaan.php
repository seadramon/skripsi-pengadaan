<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Penerimaan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_admin();
		$this->load->model(admin_folder() . '/penerimaan_model');
        $this->load->model(admin_folder() . '/detailpenerimaan_model');
        $this->load->model(admin_folder() . '/detailpermintaan_model');
        $this->load->model(admin_folder() . '/po_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'master/penerimaan';
        $this->template      = admin_folder() . '/transaksi/penerimaan/';
        $this->path_uri      = admin_folder() . '/penerimaan';
        $this->path          = base_url() . admin_folder().'/penerimaan';
        $this->title         = get_admin_menu_title('penerimaan');
        $this->id_admin_menu = get_admin_menu_id('penerimaan');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

	private $arrForm = array('idpo',
							'tanggal',
                            'idbarang',
                    'jumlah');
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
        $total_records = $this->penerimaan_model->getTotal($s_name);
        $query = $this->penerimaan_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['idpenerimaan'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            $data_array[]   = array(
                'no'                => $no,
                'id'                => $id,
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
        $this->parser->parse($template.'penerimaan', $data);
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
        $idpo       = "";
        $cancel_btn = site_url($path_uri);
        $no = 0;
        $row = array();
        $mode = "add";

        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->penerimaan_model->getByIdAll($id);
            if ($query->num_rows()>0) {
                $row = $query->result_array();

                $header = $id;
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

            $maxUrut = auto_inc('penerimaan');
            $id = sprintf("PT%05d", $maxUrut);
            $mode = "add";
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        /*FORM HEADER po*/
        $arrForm = array('idpenerimaan',
                        'idpo',
                        'tanggal',
                        'idbarang',
                        'jumlah');
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
        $this->parser->parse($template . 'penerimaan_form', $data);
        $this->global_libs->print_footer();
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);
            $arrHeader = $this->getheader($post);
            $result = $this->penerimaan_model->insert($arrHeader);

            $arrDetail = $this->getdetail($post);
            if ($result==1) {
                $resultD = $this->penerimaan_model->insertDetail($arrDetail['dpenerimaan']);
                foreach ($arrDetail['dpenerimaan'] as $row) {
                    $this->updateStatusDetailMinta($arrHeader['idpo'], $row['idbarang']);
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
            $result = $this->penerimaan_model->update($id, $arrHeader);

            $arrDetail = $this->getdetail($post);
            $clear = $this->penerimaan_model->clearDetail($id);
            if ($result==1) {
                $resultD = $this->penerimaan_model->insertDetail($arrDetail['dpenerimaan']);
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
        unset($post['dpenerimaan']);

        return $post;
    }

    private function getdetail($post = array())
    {
        if (is_array($post['dpenerimaan']) && count($post['dpenerimaan']) > 0) {
            $jml = count($post['dpenerimaan']);
            for ($i=0; $i < $jml; $i++) { 
                $post['dpenerimaan'][$i]['idpenerimaan'] = $post['idpenerimaan'];
                unset($post['dpenerimaan'][$i]['jumlahhide']);
            }

            foreach ($post as $key => $value) {
                if ($key!='dpenerimaan') {
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
        $jmlDetail = count($post['dpenerimaan']);
        $arrJml = ['jumlah'];
        $arrExcept = ['idbarang', 'jumlah', 'jumlahhide'];
        $this->replacer($post);
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

                    /*Validasi detail*/
                    if ($post['dpenerimaan'][$i][$fieldName]=='') {
                        $this->error[$fieldName] = $fieldName.' Cannot be empty';    
                    } else {
                        if ($fieldName=='jumlah') {
                            if (!ctype_digit($post['dpenerimaan'][$i][$fieldName])) {
                                $this->error[$fieldName] = $fieldName.' harus dalam bentuk angka';
                            } else {
                                if ($post['dpenerimaan'][$i][$fieldName] > $post['dpenerimaan'][$i]['jumlahhide']) {
                                    $this->error[$fieldName] = $fieldName.' tidak boleh lebih dari jumlah order pembelian';
                                }
                            }
                        }

                        /*Cek detail exist*/
                        $jml = validateDetail('detail_penerimaan', 'idpenerimaan', $post['dpenerimaan'][$i]['idbarang'], $post['idpenerimaan']);
                        if ($jml > 1) $this->error['idbarang'] = "Detail barang ada yang sudah pernah diinputkan";
                    }
                }
            }
        } else {
            $this->error['idbarang'] = "Anda belum mengisi detail penerimaan";
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
                $idpo = $post['idpo'];
                $post['idpenerimaan'] = $idheader;

                unset($post['jml_minta']);
                unset($post['idpo']);

                $jml = validateDetail('detail_penerimaan', 'idpenerimaan', $post['idbarang'], $post['idpenerimaan']);

                if ($jml<1) {
                    $result = $this->detailpenerimaan_model->insert($post);
                    $this->updateStatusDetailMinta($idpo, $post['idbarang']);

                    if ($result==1) {
                        $this->session->set_flashdata('det_success_msg', 'Detail penerimaan berhasil ditambahkan');
                    } else {
                        $this->session->set_flashdata('det_failed_msg', 'Detail penerimaan gagal ditambahkan');
                    }
                } else {
                    $this->session->set_flashdata('det_failed_msg', 'Idbarang sudah pernah ditambahkan');
                }

                redirect($this->path_uri.'/edit/'.$post['idpenerimaan']);
            } else {
                $this->session->set_flashdata('det_failed_msg', 'Anda harus mengisi form penerimaan barang terlebih dahulu');
                redirect($this->path_uri.'/add/');
            }
        }
        $this->getForm($idheader);
    }

    public function editDetail($id = "")
    {
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateFormDetail($id) ) {
            $post = purify($this->input->post());
            unset($post['jml_minta']);
            $result = $this->detailpenerimaan_model->update($id, $post);

            $jml = validateDetail('detail_penerimaan', 'idpenerimaan', $post['idbarang'], $post['idpenerimaan']);

            if ($jml<1) {
                if ($result==1) {
                    $this->session->set_flashdata('det_success_msg', 'Detail penerimaan berhasil diubah');
                } else {
                    $this->session->set_flashdata('det_failed_msg', 'Detail penerimaan gagal ditambahkan');
                }
            } else {
                $this->session->set_flashdata('det_failed_msg', 'Idbarang sudah pernah ditambahkan');
            }

            redirect($this->path_uri.'/edit/'.$post['idpenerimaan']);
        }
        $this->getForm($id, $iddetail);
    }

    private function updateStatusDetailMinta($idpo, $idbarang)
    {
        $ret = false;

        try {
            $datapo = $this->po_model->getById($idpo)->row_array();
            $idminta = $datapo['idminta'];

            $arrData = ['status' => 'arrived'];
            $id = $idminta.'_'.$idbarang;

            $ret = $this->detailpermintaan_model->update($id, $arrData);
        } catch (Exception $e) {
            dd($e->error);
        }
        return $ret;
    }

    public function dokumen($id)
    {
        $template   = $this->template;
        $this->load->library('mpdf/mpdf');
        $mpdf=new mPDF('utf-8','Legal','','','5','5','5','5','5','5','P'); 
        $mpdf->SetProtection(array('print'));
        $mpdf->SetAuthor("Damar");

        $data = $this->penerimaan_model->getByIdDokumen($id)->result_array();
        $arrData = ['data' => $data];
        $html = $this->load->view($template . 'penerimaan_dokumen', $arrData, true);

        $this->mpdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            4, // margin_left
            3, // margin right
            4, // margin top
            3, // margin bottom
            4, // margin header
            4); // margin footer

        $filename = "hello";
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output('permintaan.pdf', 'I');
    }

    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if (strlen($this->input->post('id')) > 0) {
                    $id = $this->input->post('id');
                    if ($this->detailpenerimaan_model->delete($id)) {
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