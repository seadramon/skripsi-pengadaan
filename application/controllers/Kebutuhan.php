<?php 
/**
* 
*/
class Kebutuhan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_user();

		$this->path          = base_url() . 'kebutuhan';
		$this->path_uri      = 'kebutuhan';
		$this->ctrl          = 'kebutuhan';

		$this->load->model('kebutuhan_model');
		$this->load->model('insiden_model');
	}

	// array untuk validator
    private $arrForm = array('id_tipe'  => 'Tipe',
                        'id_satuan'  => 'Satuan',
                        'quantity' => 'quantity',
                        'unit_price' => 'Total');
    private $error;

    public function index($id)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$this->main($id);

		$this->load->view('frontend/layout/footer');
	}

	public function main($id_insiden = "")
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
        $add_btn     = site_url($path_uri . '/add/'.$id_insiden);
        $back_btn	 = base_url().'insiden';
        
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
        $total_records = $this->kebutuhan_model->getTotal($id_insiden, $s_name);
        $query = $this->kebutuhan_model->getAll($id_insiden,  $s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_kebutuhan'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'tipe'           => isset($row['tipe'])?$row['tipe']:"-",
                'item'         	 => isset($row['item'])?$row['item']:"-",
                'quantity'       => isset($row['quantity'])?$row['quantity']:"-",
                'unit_price'     => isset($row['unit_price'])?$row['unit_price']:"-",
                'id_insiden'     => isset($row['id_insiden'])?$row['id_insiden']:"-",
                'edit_href'      => $edit_href
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
            'back_btn'    => $back_btn
        );
        $this->parser->parse('frontend/kebutuhan/list', $data);
	}

	public function getForm($id_insiden, $id = "")
	{
        $this->load->view('frontend/layout/header');
        $this->load->view('frontend/layout/nav');

		$file_app         = $this->ctrl;
        $path_app         = $this->path;
        $path_uri         = $this->path_uri;
        $id               = $id;
        $error_message    = array();
        $post             = array();
        $image            = "";
        $cancel_btn       = site_url($path_uri.'/index/'.$id_insiden);

        // Form attribute
        $id_tipe = get_combobox("SELECT id_tipe, nama FROM tipe", "id_tipe", "nama", "-Pilih Tipe Kebutuhan-");
        $id_item = array();
        $id_satuan = array();

        if ($id) {
            $query = $this->kebutuhan_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }

            $id_item = get_combobox("SELECT id_item, nama FROM item", "id_item", "nama", "-Pilih Item-");
            $id_satuan = get_combobox("SELECT id_satuan, nama FROM satuan", "id_satuan", "nama", "-Pilih Satuan-");
        }


        if ($id) {
            $action = site_url($path_uri.'/edit/'.$id_insiden.'/'.$id);
        } else {
            $action = site_url($path_uri.'/add/'.$id_insiden);
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('id_tipe',
                        'id_item',
                        'id_satuan',
                        'id_insiden',
                        'deskripsi',
                        'quantity',
                        'harga_satuan',
                        'unit_price');
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
            } elseif (strlen($id)>0) {
                $post[$fieldName] = $row[$fieldName];
            } else {
                $post[$fieldName] = '';
            }
        }

        $post = array($post);
        $error_message = array($error_message);

        $data = array(
            'base_url'    => base_url(),
            'id_insiden'  => $id_insiden,
            'post'        => $post,
            'action'      => $action,
            'img'         => $image,
            'id_tipe'	  => $id_tipe,
            'id_item'     => $id_item,
            'id_satuan'     => $id_satuan,
            'error_msg'   => $error_message,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/kebutuhan/create', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function add($id_insiden)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->kebutuhan_model->insert($post);            

            if ($result==1) {
            	$jml = $this->kebutuhan_model->jmlKebutuhan($id_insiden);

                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }
            redirect($this->path_uri.'/index/'.$id_insiden);

        }
        $this->getForm($id_insiden);
    }

    public function edit($id_insiden, $id = "") 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->kebutuhan_model->update($id, $post);            

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri.'/index/'.$id_insiden);
        }
        $this->getForm($id_insiden, $id);
    }

    private function validateForm()
    {
        $post = purify($this->input->post());

        foreach ($this->arrForm as $fieldName => $fieldValue) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldValue.' Cannot be empty';    
            } else {
                if($fieldName=='quantity' || $fieldName=='unit_price') {
                    if (!ctype_digit($post[$fieldName])) {
                        $this->error[$fieldName] = $fieldValue.' Harus dalam bentuk angka';            
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

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            // $post['nama'] = ucwords($post['nama']);
            $post['unit_price'] = str_replace(array(".", "Rp ", "Rp"), "", $post['unit_price']);
            $item = explode("_", $post['id_item']);
            $post['id_item'] = $item[0];
        }
    }

    public function uploadFile($name) {
        $directory = $this->config->item('base_document').'insiden/';
        // echo $directory;die();
        $filename = $_FILES['image']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $itemValue = $name . '_' . uniqid() . '.' . $ext;
        $config['upload_path'] = $directory;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
        $config['file_name'] = $itemValue;
        $config['max_file_uploads'] = 1;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('image')) {
            return $itemValue;
        } else {
            $error = $this->upload->display_errors();
            $this->error['image'] = $error;

            return false;
        }
    }

    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if (strlen($this->input->post('id')) > 0) {
                    $id = $this->input->post('id');
                    if ($this->kebutuhan_model->delete($id)) {
                        $this->session->set_flashdata('success_msg', 'barang has been deleted.');
                    } else {
                        $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
                    }
            } else {
                $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Delete failed.ID empty. Please try again.');
        }
    }

    public function getItem($idtipe = "")
    {
        if ($idtipe!="") {
            $query = get_combobox("select concat(id_item, '_', id_tipe) as iditemtipe, nama from item where id_tipe = '$idtipe'", "iditemtipe", "nama");
            echo "<option value=''>-Pilih Item-</option>";
            foreach ($query as $key => $value) {
                echo "<option value='{$key}'>$value</option>";
            }
            echo "<option value='07895928-7e9f-4338-88f6-88da04d75512'>Lain-lain</option>";
        } else {
        	echo "<option value=''>-Pilih Item-</option>";
        	echo "<option value='07895928-7e9f-4338-88f6-88da04d75512'>Lain-lain</option>";
        }
    }

    public function getSatuan($iditemtipe = "")
    {
        if ($iditemtipe!="") {
            $id_tipe = explode("_", $iditemtipe);
            $idtipe = $id_tipe[1];
            $query = get_combobox("select id_satuan, nama from satuan where id_tipe = '$idtipe'", "id_satuan", "nama");
            echo "<option value=''>-Pilih Satuan-</option>";
            foreach ($query as $key => $value) {
                echo "<option value='{$key}'>$value</option>";
            }
        } else {
        	echo "<option value=''>-Pilih Satuan-</option>";
        }
    }
}
?>