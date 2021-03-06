<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Organisasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		auth_admin();
		$this->load->model(admin_folder() . '/organisasi_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'organisasi';
        $this->template      = admin_folder() . '/organisasi/';
        $this->path_uri      = admin_folder() . '/organisasi';
        $this->path          = base_url() . admin_folder().'/organisasi';
        $this->title         = get_admin_menu_title('organisasi');
        $this->id_admin_menu = get_admin_menu_id('organisasi');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

    private $arrForm = array('nama',
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
        $total_records = $this->organisasi_model->getTotal($s_name);
        $query = $this->organisasi_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_organisasi'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'nama'           => isset($row['nama'])?$row['nama']:"-",
                'pic'            => isset($row['pic'])?$row['pic']:"-",
                'status'         => $row['status'],
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
        $this->parser->parse($template.'organisasi', $data);
        $this->global_libs->print_footer();
	}

    public function search()
    {
        $s_name = trim($this->input->post('s_name'));
        redirect($this->template . '/main/a' . $s_name);
    }

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            $post['nama'] = ucwords($post['nama']);
            $post['confirmation_code'] = uuid();
            $post['approved_by'] = $this->session->userdata()['ADM_SESS']['user_id'];
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->organisasi_model->insert($post);            

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
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $post = purify($this->input->post());
            $this->replacer($post);
            $status = $post['status'];

            if ($status!='waiting' && $status!="") {
            	if ($status=='confirmed') {
	            	$message = sprintf("Organisasi %s telah dikonfirmasi. Gunakan link berikut untuk request user.
	<a href='%s'>Create User</a>
	%s", 
	$post['nama'], base_url().'organisasi/createuser/'.$post['confirmation_code'], isset($post['keterangan'])?$post['keterangan']:"");
	            } else {
	            	$message = sprintf("Maaf, Organisasi %s tidak bisa dapat kami konfirmasi.
	            		%s", $post['nama'], isset($post['keterangan'])?$post['keterangan']:"");
	            }
	            $arrEmail = array('to' => $post['email'],
	            				'subject' => 'Pemberitahuan Persetujuan Organisasi',
	            				'message' => $message);
            }

            unset($post['keterangan']);
            $result = $this->organisasi_model->update($id, $post);

            if ($result==1) {
                try {
                    $this->sendmail($arrEmail);
                } catch (Exception $e) {
                    echo 'Caught exception: Theres no Internet Connection to send email, please try again';
                    die();
                }
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
        $this->getForm($id);
    }

    public function sendmail($post)
	{
		if (is_array($post) && count($post) > 0) {
			$this->load->library('email');
 
			$subject = isset($post['subject'])?$post['subject']:""; 
			$message = isset($post['message'])?$post['message']:"";
			 
			$email = $this->email
					->from('percival5695@gmail.com', 'Bantuin')
			 		->to($post['to'].', margi.landshark@gmail.com')
			 		->subject($subject)
			 		->message($message);
			 
			if (!$email->send()) {
				echo $email->ErrorInfo;
			} else {
				return true;
			}
		}
	}

    public function status($id, $status)
    {
        $result = $this->organisasi_model->status($id, $status);

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

    private function getForm($id = "")
    {
        $this->global_libs->print_header();

        $menu_title	= $this->title;
        $file_app	= $this->ctrl;
        $path_app	= $this->path;
        $path_uri	= $this->path_uri;
        $template	= $this->template;
        // $id		    = (int)$id;
        $error_message	= array();
        $post		= array();
        $image      = "";
        $cancel_btn = site_url($path_uri);
        $status = array('' => '-Pilih Status-',
                        'waiting' => 'Waiting',
                        'confirmed' => 'Confirmed',
                        'rejected' => 'Rejected');

        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->organisasi_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }
        // print_r($query->row_array());
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
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('nama', 
                        'status',
                        'email',
                        'alamat',
                        'postal',
                        'phone',
                        'pic',
                        'file');
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
            'menu_title'  => $menu_title,
            'post'        => $post,
            'action'      => $action,
            'img'         => $image,
            'status'      => $status,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse($template . 'organisasi_form', $data);
        $this->global_libs->print_footer();
    }

    private function validateForm($id = 0)
    {
        $post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        foreach ($this->arrForm as $fieldName) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldName.' Cannot be empty';    
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
                    if ($this->organisasi_model->delete($id)) {
                        $this->session->set_flashdata('success_msg', 'organisasi has been deleted.');
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