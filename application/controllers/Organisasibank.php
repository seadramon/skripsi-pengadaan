<?php 
/**
* 
*/
class Organisasibank extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_user();

		$this->path          = base_url() . 'organisasibank';
		$this->path_uri      = 'organisasibank';
		$this->ctrl          = 'organisasibank';
		$this->load->model('organisasi_model');
	}

	// array untuk validator
    private $arrForm = array('id_bank' => 'Bank',
                        'cabang' => 'Cabang',
                        'nama_akun' => 'Atas Nama',
                        'nomor_akun' => 'Nomor');
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
        $total_records = $this->organisasi_model->getTotalBank($s_name);
        $query = $this->organisasi_model->getAllBank($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_organisasi_bank'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);
            $edit_status    = site_url($path_uri . '/status/' . $id.'/'.$row['status']);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'cabang'         => isset($row['cabang'])?$row['cabang']:"-",
                'nama_akun'      => isset($row['nama_akun'])?$row['nama_akun']:"-",
                'nomor_akun'     => isset($row['nomor_akun'])?$row['nomor_akun']:"-",
                'organisasi'     => isset($row['organisasi'])?$row['organisasi']:"-",
                'bank'     		 => isset($row['bank'])?$row['bank']:"-",
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
        $this->parser->parse('frontend/organisasi/listbank', $data);
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
        $id_bank = get_combobox("SELECT id_bank, nama FROM bank where status = 'publish'", "id_bank", "nama", "-Pilih Bank-");

        if ($id) {
            $query = $this->organisasi_model->getByIdBank($id);
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

        $arrForm = array('id_bank',
                        'cabang',
                        'nama_akun',
                        'nomor_akun');
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
            'id_bank' 	  => $id_bank,
            'error_msg'   => $error_message,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/organisasi/createbank', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->organisasi_model->insertBank($post);            

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

            $result = $this->organisasi_model->updateBank($id, $post);            

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
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function status($id, $status)
    {
        $result = $this->organisasi_model->statusBank($id, $status);

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

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            $post['status'] = 'publish';
            $post['id_organisasi'] = $this->session->userdata('org')['id_organisasi'];
        }
    }
}
?>