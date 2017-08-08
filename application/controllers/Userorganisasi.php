<?php
/**
* 
*/
class Userorganisasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('user')['role']!='admin_org') {
			$this->load->view('frontend/layout/header');
			$this->load->view('frontend/layout/nav');
	    	$data['information'] = "Maaf, anda harus login sebagai Admin Organisasi untuk mengakses halaman ini.";
	    	$data['sukses'] = 'no';
			$this->load->view('frontend/layout/information', $data);
			$this->load->view('frontend/layout/footer');
		}

		$this->path          = base_url() . 'userorganisasi';
		$this->path_uri      = 'userorganisasi';
		$this->ctrl          = 'userorganisasi';
		$this->load->model('organisasi_model');
	}

	// array untuk validator
    private $arrForm = array('nama' => 'Nama',
                        'email' => 'Email',
                        'role' => 'Role');
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
        $total_records = $this->organisasi_model->getTotalUser($s_name);
        $query = $this->organisasi_model->getAllUser($s_name, $per_page, $lmt);
        foreach ($query as $row) {
            $no++;
            $id             = $row['id_user'];
            $edit_href      = site_url($path_uri . '/edit/' . $row['id_user']);

            if ($row['status']=='1'){
            	$row['status'] = 'aktif';
            	$updateStatus = '0';
            }else{
            	$row['status'] = 'nonaktif';
            	$updateStatus = '1';
            }
            $edit_status    = site_url($path_uri . '/status/' . $row['id_user'].'/'.$updateStatus);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'nama'           => isset($row['nama'])?$row['nama']:"-",
                'email'          => isset($row['email'])?$row['email']:"-",
                'phone'          => isset($row['phone'])?$row['phone']:"-",
                'status'         => $row['status'],
                'edit_href'      => $edit_href,
                'edit_status'    => $edit_status
            );
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
        $this->parser->parse('frontend/userorganisasi/list', $data);
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
        $role = array("" => '-Pilih Jabatan-',
						"leader" => "Leader",
						"admin_org" => "Admin Organisasi",
						"korlog" => "Korlog",
						"korlap" => "Korlap");

        if ($id) {
            $query = $this->organisasi_model->getUserById($id);
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
                        'email',
                        'role');
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
        // print_r($cancel_btn);die();
        $data = array(
            'base_url'    => base_url(),
            'post'        => $post,
            'action'      => $action,
            'img'         => $image,
            'role'		  => $role,
            'error_msg'   => $error_message,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/userorganisasi/create', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateUser()) {
            $post = purify($this->input->post());
			$result = $this->organisasi_model->insertUser($post);           

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
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateUser()) {
            $post = purify($this->input->post());
			$result = $this->organisasi_model->updateUser($id, $post);           

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri);
        }
        $this->getForm($id);
    }

    private function validateUser()
	{
		$post = purify($this->input->post());
		// print_r($this->arrForm);die();
        foreach ($this->arrForm as $fieldName => $fieldValue) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldValue.' Cannot be empty';    
            } else {
                if($fieldName=='email') {
                    if (!filter_var($post[$fieldName], FILTER_VALIDATE_EMAIL)) {
                        $this->error[$fieldName] = $fieldValue.' Tidak Valid';            
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

    public function status($id, $status)
    {
        $result = $this->organisasi_model->statusUser($id, $status);

        if ($result) {
            $this->session->set_flashdata('success_msg', 'status has been updated');
        } else {
            $this->session->set_flashdata('error_msg', 'status cannot be updated');
        }

        if ($this->session->userdata('referrer') != '') {
            redirect($this->session->userdata('referrer'));
        } else {
            redirect($this->path_uri);
        }
    }

    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if (strlen($this->input->post('id')) > 0) {
                    $id = $this->input->post('id');
                    if ($this->organisasi_model->deleteUser($id)) {
                        $this->session->set_flashdata('success_msg', 'user has been deleted.');
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
}