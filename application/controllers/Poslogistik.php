<?php 
/**
* 
*/
class Poslogistik extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_user();

		$this->path          = base_url() . 'poslogistik';
		$this->path_uri      = 'poslogistik';
		$this->ctrl          = 'poslogistik';

		$this->load->model('poslogistik_model');
		$this->load->model('insiden_model');
	}

	// array untuk validator
    private $arrForm = array('id_user'  => 'id_user',
                        'nama'  => 'Nama',
                        'alamat' => 'alamat',
                        'telp' => 'Nomor Telepon');
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
        $total_records = $this->poslogistik_model->getTotal($id_insiden, $s_name);
        $query = $this->poslogistik_model->getAll($id_insiden,  $s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_poslogistik'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'id_user'        => isset($row['id_user'])?$row['id_user']:"-",
                'korlog'         => isset($row['korlog'])?$row['korlog']:"-",
                'nama'           => isset($row['nama'])?$row['nama']:"-",
                'insiden'        => isset($row['insiden'])?$row['insiden']:"-",
                'id_insiden'     => isset($row['id_insiden'])?$row['id_insiden']:"-",
                'telp'           => isset($row['telp'])?$row['telp']:"-",
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
        $this->parser->parse('frontend/poslogistik/list', $data);
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
        $this->db->where('id_insiden', $id_insiden);
        $this->db->select('id_user');
        $korlogexcept = $this->db->get('pos_logistik')->result_array();

        if (count($korlogexcept) >0) {
            $arrKorlogexc = array();
            foreach ($korlogexcept as $val) {
                $arrKorlogexc[]=$val['id_user'];
            }
            $korlogexception = implode(",", $arrKorlogexc);
            $cbQuery = sprintf("SELECT korlog.id_user as id_user, user.nama as nama from korlog right join user on korlog.id_user = user.id_user where korlog.id_organisasi = '%s'  and korlog.id_user not in ('%s')", $this->session->userdata('org')['id_organisasi'], $korlogexception);
        } else {
            $cbQuery = sprintf("SELECT korlog.id_user as id_user, user.nama as nama from korlog right join user on korlog.id_user = user.id_user where korlog.id_organisasi = '%s'", $this->session->userdata('org')['id_organisasi']);
        }
        
        $id_user = get_combobox($cbQuery,
                 "id_user", "nama", "-Pilih Korlog-");        

        if ($id) {
            $query = $this->poslogistik_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }

            $id_item = get_combobox("SELECT id_item, nama FROM item", "id_item", "nama", "-Pilih Item-");
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

        $arrForm = array('id_user',
                        'id_insiden',
                        'nama',
                        'alamat',
                        'telp',
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
            'id_user'	  => $id_user,
            'error_msg'   => $error_message,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/poslogistik/create', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function add($id_insiden)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->poslogistik_model->insert($post);            

            if ($result) {
                // $this->updateKorlog($post['id_user'], $result);

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

            $result = $this->poslogistik_model->update($id, $post);            

            if ($result==1) {
                // $this->updateKorlog($post['id_user'], $id);

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
                if($fieldName=='telp') {
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

    private function updateKorlog($id_user, $id_poslogistik)
    {
        $this->load->model('organisasi_model');
        $this->organisasi_model->assignKorlog($id_user, $id_poslogistik);
    }

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            $post['nama'] = ucwords($post['nama']);
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
                    if ($this->poslogistik_model->delete($id)) {
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
            $query = get_combobox("select id_item, nama from item where id_tipe = '$idtipe'", "id_item", "nama");
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

    public function getSatuan($idtipe = "")
    {
        if ($idtipe!="") {
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