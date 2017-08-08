<?php 
/**
* 
*/
class Pemberibantuan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        // auth_user();

		$this->path          = base_url() . 'pemberibantuan';
		$this->path_uri      = 'pemberibantuan';
		$this->ctrl          = 'pemberibantuan';

		$this->load->model('pemberibantuan_model');
	}

    // array untuk validator
    private $arrForm = array('nama' => 'Nama',
                        'birth_date' => 'Tanggal Lahir',
                        'alamat' => 'Alamat',
                        'email' => 'email',
                        'phone' => 'No Telp',
                        'jk' => 'Jenis Kelamin',
                        'password' => 'password',
                        'confirm_password' => 'Confirm Password');
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
        $total_records = $this->pemberibantuan_model->getTotal($s_name);
        $query = $this->pemberibantuan_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_insiden'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);
            $edit_status    = site_url($path_uri . '/status/' . $id.'/'.$row['status']);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'nama'           => isset($row['nama'])?$row['nama']:"-",
                'korban'         => isset($row['korban'])?$row['korban']:"-",
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
        $success_reg	  = "";

        // Form attribute
        $jk = array('laki-laki' => 'Laki-laki',
        	'perempuan' => 'Perempuan');

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
            $action = site_url($path_uri.'/register');
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('nama',
                        'birth_date',
                        'alamat',
                        'email',
                        'phone',
                        'jk',
                        'password',
                        'confirm_password');
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
       	$success_reg = alert_box($this->session->flashdata('success_reg'), 'success');

        $data = array(
            'base_url'    => base_url(),
            'post'        => $post,
            'action'      => $action,
            'error_msg'   => $error_message,
            'success_reg' => $success_reg,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'jk'	      => $jk,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/pemberibantuan/register', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->pemberibantuan_model->insert($post);            

            if ($result==1) {
                $this->session->set_flashdata('success_reg', 'Selamat Pendaftaran Anda berhasil');
            } else {
                $this->session->set_flashdata('error_reg', 'Maaf, Pendaftaran gagal dilakukan');
            }

            redirect($this->path_uri.'/register');
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

            $result = $this->pemberibantuan_model->update($id, $post);            

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
                if($fieldName=='telp') {
                    if (!ctype_digit($post[$fieldName])) {
                        $this->error[$fieldName] = $fieldValue.' Harus dalam bentuk angka';            
                    }
                }

                if ($fieldName=='email') {
                	if (!filter_var($post[$fieldName], FILTER_VALIDATE_EMAIL)) {
                		$this->error[$fieldName] = $fieldValue.' Tidak valid';
                	} else {
                		$jml = $this->pemberibantuan_model->userExist($post[$fieldName]);
	                	if ($jml>0) {
	                		$this->error[$fieldName] = 'Email sudah digunakan';	
	                	}
                	}
                }
            }
        }

        if ($post['password']!="" && $post['confirm_password']!="") {
        	if ($post['password']!=$post['confirm_password']) {
	        	$this->error['password'] = "Konfirmasi Password tidak sesuai";
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
            $post['role'] = 'pemberibantuan';
            $post['password'] = md5($post['password']);
            unset($post['confirm_password']);
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
                    if ($this->pemberibantuan_model->delete($id)) {
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
}
?>