<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    private $error = array();
    private $folder;
    private $ctrl;
    private $template;
    private $path;
    private $path_uri;
    private $title;
	private $max_width;
    private $max_height;
    private $thumb_width;
    private $thumb_height;
    private $thumb2_width;
    private $thumb2_height;
    private $path_pict;
    private $id_menu_admin;
    private $is_superadmin;
    
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        auth_admin();
        $this->load->model(admin_folder() . '/user_model');
        $this->load->model(admin_folder() . '/admin_model');

        $this->folder       = admin_folder();
        $this->ctrl         = 'user';
        $this->template     = admin_folder() . '/user';
        $this->path_uri     = admin_folder() . '/user';
        $this->path         = site_url() . admin_folder() . '/user';
        $this->title        = get_admin_menu_title('user');
		$this->max_width    = 281;
        $this->max_height   = 392;
		$this->thumb_width  = 75;
        $this->thumb_height = 75;
        $this->thumb2_width = 150;
        $this->thumb2_height= 150;
		$this->path_pict    = './uploads/avatar/';
        $this->id_menu_admin= get_admin_menu_id('user');
        $this->is_superadmin= adm_is_superadmin(adm_sess_userid());
    }

    /**
     * index page = main page
     */
    public function index()
    {
        $this->main();
    }

    /**
     * main page = index page
     */
    public function main()
    {
        $this->session->set_userdata('referrer', current_url());
        $this->global_libs->print_header();

        $s_name         = $this->uri->segment(4);
        $s_email        = $this->uri->segment(5);
        $pg             = $this->uri->segment(6);
        $per_page       = 10;
        $uri_segment 	= 6;
        $path           = $this->path.'/main/a/b/';
        $data_array     = array();
        $menu_title     = $this->title;
        $file_app       = $this->ctrl;
        $path_app       = $this->path;
        $path_uri       = $this->path_uri;
        $template       = $this->template;
        $add_btn        = site_url($path_uri.'/add');

        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);
        
        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => '#',
                'class' => 'class="current"'
        );

        if (strlen($s_name) > 1) $s_name = substr($s_name, 1);
        else $s_name = '';

        if (strlen($s_email) > 1) $s_email = substr($s_email, 1);
        else $s_email = '';

        $total_records = $this->user_model->getTotalUser($s_name, $s_email);

        if ($s_name) {
            $path = str_replace('/a/', '/a' . $s_name . '/', $path);
        }

        if ($s_email) {
            $path = str_replace('/b/', '/b' . $s_email . '/', $path);
        }

        if (!$pg) {
            $lmt = 0;
            $pg = 1;
        } else {
            $lmt = $pg;
        }
        $no=$lmt;

        // $query = $this->user_model->getAllUser($s_name, $s_email, $lmt, $per_page);
        $query = $this->user_model->getAllUser();
        
        foreach ($query->result_array() as $row) {
            $no++;

            $toggle_href = site_url($path_uri . '/togglePaymentStatus/' . $row['nik']);
            /*if ($row['payment_status']) {
                $status = '<a href="' . $toggle_href . '" class="label label-success">Verified</a>';
            } else {
                $status = '<a href="' . $toggle_href . '" class="label label-danger">Unverified</a>';
            }*/
            $status = '<a href="#"></a>';

            $id        = $row['nik'];
            $name      = $row['nama'];
            $email     = $row['email'];
            $edit_href = site_url($path_uri . '/edit/' . $id);
            $edit_status = site_url($path_uri . '/status/' . $id.'/'.$row['status']);
            
            $data_array[] = array(
                'no'        => $no,
                'id'        => $id,
                'email'     => $email,
                'name'      => $name,
                'divisi'     => $row['namaDivisi'],
                'edit_href' => $edit_href,
                'edit_status' => $edit_status,
                'status'    => $row['status'],
            );
        }

        // paging
        $paging = global_paging($total_records,$per_page,$path,$uri_segment);
        if (!$paging) $paging = '<ul class="pagination"><li class="current"><a>1</a></li></ul>';
        //end of paging

        $error_message = alert_box($this->session->flashdata('error_msg'), 'error');
        $success_msg   = alert_box($this->session->flashdata('success_msg'), 'success');
        $info_msg      = alert_box($this->session->flashdata('info_msg'), 'warning');

        $data = array(
            'base_url' 	  => base_url(),
            'current_url' => current_url(),
            'menu_title'  => $menu_title,
            'data'        => $data_array,
            's_name' 	  => $s_name,
            's_email'	  => $s_email,
            'breadcrumbs' => $breadcrumbs,
            'pagination'  => $paging,
            'error_msg'	  => $error_message,
            'success_msg' => $success_msg,
            'info_msg'	  => $info_msg,
            'file_app'	  => $file_app,
            'path_app'	  => $path_app,
            'add_btn'	  => $add_btn,
        );
        $this->parser->parse($template . '/user', $data);
        $this->global_libs->print_footer();
    }

    /**
     * add page
     */
    public function add()
    {
        // print_r($_POST);
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $total = 0;
            $iddivisi = "";
            $group_id = "";
            $post = purify($this->input->post());


            if ($post['divisigroup']!='') {
                $arrSpl = explode("_", $post['divisigroup']);
                $iddivisi = $arrSpl[0];
                $group_id = $arrSpl[1];
            }

            if ($post['status']=='') {
                $post['status'] = 'aktif';
            }

            $now = date('Y-m-d H:i:s');
            $password = $this->phpass->hash($post['password']);

            $data_post = array(
                'nik'               => $post['nik'],
                'iddivisi'          => $iddivisi,
                'group_id'          => $group_id,
                'nama'              => $post['nama'],
                'alamat'            => $post['alamat'],
                'jk'                => $post['jk'],
                'telp'              => $post['telp'],
                'email'             => strtolower($post['email']),
                'jabatan'           => $post['jabatan'],
                'password'          => $password,
                'created'           => $now,
                'status'            => $post['status']
            );

            // insert data
            $id = $this->user_model->insert($data_post);
            if ($id) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri);
        }
        $this->getForm();
    }

    /**
     * edit page
     * @param int $get_id 
     */
    public function edit($id = 0)
    {
        $id = (int) $id;

        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            if ($this->session->userdata('referrer') != '') {
                redirect($this->session->userdata('referrer'));
            } else {
                redirect($this->path_uri);
            }
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id) ) {
            $post = purify($this->input->post());
            if ($post['divisigroup']!='') {
                $arrSpl = explode("_", $post['divisigroup']);
                $iddivisi = $arrSpl[0];
                $group_id = $arrSpl[1];
            }

            if ($post['status']=='') {
                $post['status'] = 'aktif';
            }
            
            $data_post = array(
                'iddivisi'          => $iddivisi,
                'group_id'          => $group_id,
                'nama'              => $post['nama'],
                'alamat'            => $post['alamat'],
                'jk'                => $post['jk'],
                'telp'              => $post['telp'],
                'email'             => strtolower($post['email']),
                'status'            => $post['status']
            );

            if (($post['password'] != '') && (strlen($post['password']) >= 5)) {
                $pass = $this->phpass->hash($post['password']);
                $data_pass = array('password' => $pass);
                $data_post = array_merge($data_post, $data_pass);
            }
			
            // update data
            $this->user_model->update($id, $data_post);

            if ($post['payment_status'] == 1) {
                $this->notifyUser($id);
            }

            $this->session->set_flashdata('success_msg', $this->title.' has been updated');

            if ($this->session->userdata('referrer') != '') {
                redirect($this->session->userdata('referrer'));
            } else {
                redirect($this->path_uri);
            }
        }
        $this->getForm($id);
    }

    /**
     * search post s_name and s_email
     */
    public function search()
    {
        $s_name = trim($this->input->post('s_name'));
        $s_email = trim($this->input->post('s_email'));
        redirect($this->template.'/main/a'.$s_name.'/b'.$s_email);
    }

    /**
     * delete page post id
     */
    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if ( (ctype_digit($this->input->post('id'))) && ($this->input->post('id')>0)) {
                $id = $this->input->post('id');
                $this->user_model->delete($id);
                $this->session->set_flashdata('success_msg', $this->title.' (s) has been deleted.');
            } else {
                $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
        }
    }

    public function togglePaymentStatus($user_id)
    {
        $result = $this->user->togglePaymentStatus($user_id);

        if ($result['status']) {
            $this->session->set_flashdata('success_msg', 'User payment status changed successfully');

            if ($result['val'] == 1) {
                $this->notifyUser($user_id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Fail to change user payment status');
        }

        if ($this->session->userdata('referrer') != '') {
            redirect($this->session->userdata('referrer'));
        } else {
            redirect($this->path_uri);
        }
    }

    private function notifyUser($user_id)
    {
        $user = $this->user->get($user_id)->row_array();

        //Start Send SMS
        if ($user['lang'] == 'id') {
            $msg  = 'Selamat! ';
            $msg .= 'data anda telah valid silahkan cek email anda dan sampai jumpa pada acara INDONESIA SCM SUMMIT 2015. ';
            $msg .= 'Informasi lebih lanjut klik www.scmsummit.co.id';
        } else {
            $msg  = 'Congratulations! ';
            $msg .= 'your data is valid, please check your email and look forward to meet you on SCM SUMMIT 2015. ';
            $msg .= 'More information please click www.scmsummit.co.id';
        }
        send_sms($user['phone'], $msg);
        //End Send SMS

        //Start Send Email
        $mail_data['name']     = $user['name'];
        $mail_data['email']    = $user['email'];
        $mail_data['phone']    = $user['phone'];
        $mail_data['password'] = $user['password_plain'];

        $message = $this->load->view('email/'. $user['lang'] .'/validated', $mail_data, true);

        $this->load->library('email');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from('noreply@scmsummit.co.id', 'SCM Summit');
        $this->email->to($mail_data['email']);

        $this->email->subject('SCM Summit Registration');
        $this->email->message($message);

        $this->email->send();
        //End Send Email
    }
    
    
    /////////////////////////////////////////////////////////////////
    /////////////////////////// private /////////////////////////////
    /////////////////////////////////////////////////////////////////
    
    /**
     * get print form
     * @param int $id 
     */
    private function getForm($id=0)
    {
        $this->global_libs->print_header();

        $menu_title	= $this->title;
        $file_app	= $this->ctrl;
        $path_app	= $this->path;
        $path_uri	= $this->path_uri;
        $template	= $this->template;
        $id		    = (int)$id;
        $error_message	= array();
		$ava        = '';
        $post       = array();
        $cancel_btn = site_url($path_uri);

        /*NIK*/
        $maxUrut = auto_inc('karyawan');
        $nik = date('ym').sprintf("%04d", $maxUrut);

        $jk = ['' => '-Pilih Jenis Kelamin-',
            'laki-laki' => 'laki-laki',
            'perempuan' => 'perempuan'
        ];
        $status = array('' => '-Pilih Status-',
                        'aktif' => 'aktif',
                        'non aktif' => 'non aktif');
        $divisi = get_combobox("select concat(iddivisi, '_', id) as divisigroup, name from db_pengadaan.group", "divisigroup", "name", "-Pilih Divisi-");

        $breadcrumbs = $this->global_libs->getBreadcrumbs($file_app);
        
        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->user_model->get($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg','There is no record in our database.');
                redirect($template);
            }
        }

        if ($id) {
            $breadcrumbs[] = array(
                'text'   => 'Edit',
                'href'   => '#',
                'class'	=> 'class="current"'
            );
            $err_c = 'error-info ';
            /*if ($row['avatar'] != '') {
				$ava = '<img src ="' . base_url() . 'uploads/avatars/' . $row['avatar'] . '" style="width:40px;height:45px;margin-bottom:10px;" /><br />';
			}*/
			$required = '';
            $pass_msg = '<small class="error-info">Please ignore this field if you don\'t want to change.</small>';
            $action = site_url($template . '/edit/' . $id);
        } else {
            $breadcrumbs[] = array(
                'text'   => 'Add',
                'href'   => '#',
                'class'	=> 'class="current"'
            );
            $pass_msg = '';
            $err_c    = '';
            $required = 'required';
            $action   = site_url($template . '/add');
        }

        // set error----------------------------------------------------------------------
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'],'warning');
        } else {
            $error_message['warning'] = '';
        }

        if (isset($this->error['password'])) {
            $error_message['password'] = alert_box($this->error['password'],'error');
        } else {
            $error_message['password'] = '';
        }

        if (isset($this->error['nama'])) {
            $error_message['nama'] = alert_box($this->error['nama'],'error');
        } else {
            $error_message['nama'] = '';
        }

        if (isset($this->error['email'])) {
            $error_message['email'] = alert_box($this->error['email'],'error');
        } else {
            $error_message['email'] = '';
        }

        if (isset($this->error['nik'])) {
            $error_message['nik'] = alert_box($this->error['nik'],'error');
        } else {
            $error_message['nik'] = '';
        }

        if (isset($this->error['telp'])) {
            $error_message['telp'] = alert_box($this->error['telp'],'error');
        } else {
            $error_message['telp'] = '';
        }

        if (isset($this->error['divisigroup'])) {
            $error_message['divisigroup'] = alert_box($this->error['divisigroup'],'error');
        } else {
            $error_message['divisigroup'] = '';
        }

        // set value----------------------------------------------------------------------
        if ($this->input->post('nik') != '') {
            $post['nik'] = $this->input->post('nik');
        } elseif ((int)$id>0) {
            $post['nik'] = $row['nik'];
        } else {
            $post['nik'] = $nik;
        }

        if ($this->input->post('nama') != '') {
            $post['nama'] = $this->input->post('nama');
        } elseif ((int)$id>0) {
            $post['nama'] = $row['nama'];
        } else {
            $post['nama'] = '';
        }

        if ($this->input->post('email') != '') {
            $post['email'] = $this->input->post('email');
        } elseif ((int)$id>0) {
            $post['email'] = $row['email'];
        } else {
            $post['email'] = '';
        }

        if ($this->input->post('alamat') != '') {
            $post['alamat'] = $this->input->post('alamat');
        } elseif ((int)$id>0) {
            $post['alamat'] = $row['alamat'];
        } else {
            $post['alamat'] = '';
        }

        if ($this->input->post('jk') != '') {
            $post['jk'] = $this->input->post('jk');
        } elseif ((int)$id>0) {
            $post['jk'] = $row['jk'];
        } else {
            $post['jk'] = '';
        }

		if ($this->input->post('telp') != '') {
            $post['telp'] = $this->input->post('telp');
        } elseif ((int)$id>0) {
            $post['telp'] = $row['telp'];
        } else {
            $post['telp'] = '';
        }

        if ($this->input->post('jabatan') != '') {
            $post['jabatan'] = $this->input->post('jabatan');
        } elseif ((int)$id>0) {
            $post['jabatan'] = $row['jabatan'];
        } else {
            $post['jabatan'] = '';
        }

        if ($this->input->post('status') != '') {
            $post['status'] = $this->input->post('status');
        } elseif ((int)$id>0) {
            $post['status'] = $row['status'];
        } else {
            $post['status'] = '';
        }

        if ($this->input->post('divisigroup') != '') {
            $post['divisigroup'] = $this->input->post('divisigroup');
        } elseif ((int)$id>0) {
            $post['divisigroup'] = $row['iddivisi'].'_'.$row['group_id'];
        } else {
            $post['divisigroup'] = '';
        }

        // generate group
        // $post['group_list'] = $this->getGroupSelect($post['group_id']);

        $post = array($post);
        $error_message = array($error_message);

        $data = array(
            'base_url'    => base_url(),
            'menu_title'  => $menu_title,
            'post'        => $post,
            'jk'          => $jk,
            'status'      => $status,
            'divisi'      => $divisi,
			'pass_msg'    => $pass_msg,
            'err_c'       => $err_c,
            'required'    => $required,
            'action'      => $action,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'cancel_btn'  => $cancel_btn,
        );		
        $this->parser->parse($template.'/user_form', $data);
        $this->global_libs->print_footer();		
    }

    /**
     *
     * @param int $id
     * @return string $this->error error 
     */
    private function validateForm($id="", $group_id = null)
    {
        // $id = (int)$id;
        $post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        if ($post['divisigroup']=='') {
            $this->error['divisigroup'] = 'Divisi belum dipilih.<br/>';
        }

        if ($post['nama'] == '') {
            $this->error['nama'] = 'Nama tidak boleh kosong.<br/>';
        }

        if ($post['telp'] == '') {
            $this->error['telp'] = 'telp tidak boleh kosong.<br/>';
        } else {
            if (!ctype_digit($post['telp'])) {
                $this->error['telp'] = 'no telp harus dalam bentuk angka.<br/>';    
            }
        }

        if ($post['email'] == '') {
            $this->error['email'] = 'Email tidak boleh kosong.<br/>';
        } else {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error['email'] = 'Format email tidak valid.<br/>';
            } else {
                 if($this->admin_model->checkDuplicateEmail($post['email'], $id, $group_id)) {
                     $this->error['email'] = 'Email sudah digunakan.<br/>';
                 }
            }
        }

        if ($post['telp']!='') {
            if (!ctype_digit($post['telp'])) {
                $this->error['telp'] = 'Nomor telepon harus dalam bentuk angka.<br/>';    
            }
        }

        /* PASSWORD */
        if ($id) {
            if ($post['password'] != '') {
                if ($post['password'] != $post['passconf']) {
                    $this->error['password'] = 'Confirm Password didn\'t match with New Password.<br/>';
                } elseif (strlen($post['password']) < 5) {
                        $this->error['password'] = 'Password length must be at least 5 character(s).<br/>';
                }
            }
        } else {
            if ($post['password'] == '') {
                $this->error['password'] = 'Please insert Password.<br/>';
            } elseif (strlen($post['password']) < 5) {
                    $this->error['password'] = 'Password length must be at least 5 character(s).<br/>';
            } elseif ($post['password'] != $post['passconf']) {
                $this->error['password'] = 'Confirm Password didn\'t match with New Password.<br/>';
            }
        }
        /* END PASSWORD */

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function getGroupSelect($selected_id='')
    {
        $this->load->model('group_model');
        $query = $this->group_model->getAll();
        $return = '';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $sel = '';
                if ($row['id'] == $selected_id) $sel = ' selected';
                $return .= '<option value="'.$row['id'].'"'.$sel.'>'.$row['name'].'</option>';
            }
        }
        return $return;
    }

    public function status($id, $status)
    {
        $result = $this->user_model->status($id, $status);

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
}
