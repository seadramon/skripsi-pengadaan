<?php 
/**
* 
*/
class Insiden extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        auth_user();

		$this->path          = base_url() . 'insiden';
		$this->path_uri      = 'insiden';
		$this->ctrl          = 'insiden';

		$this->load->model('insiden_model');
        $this->load->model('kebutuhan_model');
        $this->load->model('poslogistik_model');
	}

    // array untuk validator
    private $arrForm = array('nama' => 'nama',
                        'id_kategori' => 'kategori',
                        'id_fase'  => 'fase',
                        'deskripsi' => 'deskripsi',
                        'alamat' => 'alamat',
                        'terms' => 'terms',
                        'korban' => 'korban',
                        'estimasi' => 'estimasi');
    private $error;

	public function index()
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$this->main();

		$this->load->view('frontend/layout/footer');
	}

	public function main()
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
        $total_records = $this->insiden_model->getTotal($s_name);
        $query = $this->insiden_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_insiden'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);
            $edit_status    = site_url($path_uri . '/status/' . $id.'/'.$row['status']);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'nama'           => isset($row['nama'])?$row['nama']:"-",
                'korban'         => isset($row['korban'])?$row['korban'].' jiwa':"-",
                'fase'           => isset($row['fase'])?$row['fase']:"-",
                'kategori'       => isset($row['kategori'])?$row['kategori']:"-",
                'status'         => $row['status'],
                'edit_href'      => $edit_href,
                'edit_status'    => $edit_status
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
        );
        $this->parser->parse('frontend/insiden/list', $data);
	}

	public function getForm($id = "")
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
        $cancel_btn       = site_url($path_uri);

        // Form attribute
        $id_kategori = get_combobox("SELECT id_kategori, nama FROM kategori where status = 'publish'", "id_kategori", "nama", "-Pilih Kategori-");
        $id_fase = get_combobox("SELECT id_fase, nama FROM fase", "id_fase", "nama", "-Pilih Fase-");

        if ($id) {
            $query = $this->insiden_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }


        if ($id) {
            $action = site_url($path_uri.'/edit/'.$id);
        } else {
            $action = site_url($path_uri.'/add');
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('nama',
                        'id_kategori',
                        'id_fase',
                        'deskripsi',
                        'alamat',
                        'terms',
                        'korban',
                        'estimasi',
                        'image');
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
            'post'        => $post,
            'action'      => $action,
            'img'         => $image,
            'id_kategori' => $id_kategori,
            'id_fase'     => $id_fase,
            'error_msg'   => $error_message,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/insiden/create', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            if (!empty($_FILES['image']['name'])) {
                $file = $this->uploadFile(str_replace(' ', '', $post['nama']));

                if ($file) {
                    $post['image'] = $file;
                } else {
                    $this->getForm();
                }
            }

            $post['status'] = 'Kebutuhan Kosong';
            $result = $this->insiden_model->insert($post);            

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri);
        }
        $this->getForm();
    }

    public function edit($id = "") 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            if (!empty($_FILES['image']['name'])) {
                $file = $this->uploadFile(str_replace(' ', '', $post['nama']));

                if ($file) {
                    $post['image'] = $file;
                } else {
                    $this->getForm();
                }
            }

            $result = $this->insiden_model->update($id, $post);            

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri);
        }
        $this->getForm($id);
    }

    private function validateForm()
    {
        $post = purify($this->input->post());

        foreach ($this->arrForm as $fieldName => $fieldValue) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldValue.' Cannot be empty';    
            } else {
                if($fieldName=='korban') {
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
            $post['nama'] = ucwords($post['nama']);
            $post['id_organisasi'] = $this->session->userdata('org')['id_organisasi'];
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
                    if ($this->insiden_model->delete($id)) {
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

    public function detail($id_insiden)
    {
        $this->load->view('frontend/layout/header');
        $this->load->view('frontend/layout/nav');

        $insiden = $this->insiden_model->showById($id_insiden)->row_array();
        $kebutuhan = $this->kebutuhan_model->showByInsiden($id_insiden);
        $posko = $this->poslogistik_model->showByInsiden($id_insiden);
        $this->load->model('admpage/tipe_model');
        $tipe = $this->tipe_model->showName();
        $cancel_btn = site_url($this->path_uri);
        $action = site_url($this->path_uri.'/confirmInsiden');

        $data = array('insiden' => $insiden,
            'kebutuhan' => $kebutuhan,
            'posko' => $posko,
            'tipe' => $tipe,
            'action' => $action,
            'cancel_btn' => $cancel_btn);

        $this->load->view('frontend/insiden/detail', $data);
        $this->load->view('frontend/layout/footer');
    }

    public function confirmInsiden()
    {
        $post = purify($this->input->post());
        // print_r($post);die();
        if ($post['id_insiden']!="") {
            if ($this->insiden_model->confirmInsiden($post['id_insiden'], $post['status'])) {

                $this->session->set_flashdata('success_msg', 'Konfirmasi insiden berhasil');
            } else {
                $this->session->set_flashdata('error_msg', 'Konfirmasi insiden gagal dilakukan');
            }
        }
        redirect($this->path_uri);
    }

    public function bantuan($id_insiden, $tipe = "Dana")
    {
        $this->load->view('frontend/layout/header');
        $this->load->view('frontend/layout/nav');

        $this->load->model('bantuan_model');
        $this->load->model('kebutuhan_model');

        $tabtipes = $this->bantuan_model->tipe();
        if ($this->session->userdata('user')['role']=='korlog') {
            $korlogexception = array('Logistik', 'Dana');
            $i = 0;
            foreach ($tabtipes as $val) {
                if (!in_array($val['nama'], $korlogexception)) {
                    unset($tabtipes[$i]);
                }
                $i++;
            }
        }else{
            $korlogexception = array('Logistik');
            $i = 0;
            foreach ($tabtipes as $val) {
                if (in_array($val['nama'], $korlogexception)) {
                    unset($tabtipes[$i]);
                }
                $i++;
            }
        }

        $tabtipe = array_values($tabtipes);
        $id_tipe = $this->db->get_where('tipe', array('nama' => $tipe))->row('id_tipe');
        $insiden = $this->insiden_model->showById($id_insiden)->row_array();

        $s_name      = $this->uri->segment(5);
        $pg          = $this->uri->segment(6);
        $per_page    = 10;
        $uri_segment = 6;
        $no          = 0;
        $path        = $this->path.'/main/a/';
        $path_uri    = $this->path_uri;
        $data_array  = array();
        $file_app    = $this->ctrl;
        $path_app    = $this->path;
        $persentase  = "";
        $add_btn     = site_url($path_uri . '/add');
        $total_records = 0;
        
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

        if ($tipe!="Dana") {
            $total_records = $this->bantuan_model->getTotalBantuan($id_insiden, $id_tipe);
            $query = $this->bantuan_model->getAllBantuan($id_insiden, $id_tipe, $per_page, $lmt);
            $persentase = $this->kebutuhan_model->getPersentase($id_insiden, $id_tipe);

            foreach ($query as $row) {
                $no++;
                $id             = $row['id_detail_bantuan'];

                $data_array[]   = array(
                    'no'             => $no,
                    'id'             => $id,
                    'id_bantuan'     => isset($row['id_bantuan'])?$row['id_bantuan']:"-",
                    'id_tipe'        => isset($row['id_tipe'])?$row['id_tipe']:"-",
                    'id_insiden'     => isset($row['id_insiden'])?$row['id_insiden']:"-",
                    'pemberibantuan' => isset($row['pemberibantuan'])?$row['pemberibantuan']:"-",
                    'pos'            => isset($row['pos'])?$row['pos']:"-",
                    'satuan'         => isset($row['satuan'])?$row['satuan']:"-",
                    'item'           => isset($row['item'])?$row['item']:"-",
                    'quantity'       => isset($row['quantity'])?$row['quantity']:"-",
                    'quantity_received'=> isset($row['quantity_received'])?$row['quantity_received']:"-",
                    'quantity'       => isset($row['quantity'])?$row['quantity']:"-",
                    'created'        => isset($row['created'])?$row['created']:"-",
                    'status'         => $row['status'],
                );
            }
        } else {
            $query = $this->bantuan_model->jmlPerDana($id_insiden);
        }
        
        // paging
        $paging = global_paging($total_records, $per_page, $path, $uri_segment);
        if(!$paging) $paging = '<ul class="pagination pagination-sm no-margin pull-left"><li class="active"><a>1</a></li></ul>';
        //end of paging
        
        $data = array(
            'base_url'    => base_url(),
            'current_url' => current_url(),
            's_name'      => $s_name,
            'insiden'     => $insiden,
            'data'        => $query,
            'arrdata'     => $data_array,
            'pagination'  => $paging,
            'path_uri'    => $path_uri,
            'tabtipe'     => $tabtipe,
            'tipe'        => $tipe,
            'persentase'  => $persentase,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'add_btn'     => $add_btn,
        );

        $this->load->view('frontend/aturbantuan/header', $data);
        if ($tipe=='Dana') {
            $this->load->view('frontend/aturbantuan/totalDana', $data);
        } else {
            // $this->load->view('frontend/aturbantuan/listbantuan', $data);
            $this->parser->parse('frontend/aturbantuan/listbantuan', $data);
        }
        $this->load->view('frontend/layout/footer');
    }
}
?>