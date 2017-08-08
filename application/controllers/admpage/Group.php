<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {
	
    private $error = array();
    private $folder;
    private $ctrl;
    private $template;
    private $path;
    private $title;
    private $id_admin_menu;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();

        auth_admin();
        $this->load->model(admin_folder() . '/group_model');
        $this->load->model(admin_folder() . '/divisi_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'group';
        $this->template      = admin_folder() . '/group';
        $this->path_uri      = admin_folder() . '/group';
        $this->path          = base_url() . admin_folder().'/group';
        $this->title         = get_admin_menu_title('group');
        $this->id_admin_menu = get_admin_menu_id('group');
    }

    /**
     * index page
     */
    public function index()
    {
        $this->main();
    }

    /**
     * main page
     */
    public function main()
    {
        $this->session->set_userdata('referrer', current_url());
        $this->global_libs->print_header();

        $s_name		 = $this->uri->segment(4);
        $pg 		 = $this->uri->segment(5);
        $per_page 	 = 10;
        $uri_segment = 5;
        $no		 	 = 0;
        $path		 = $this->path.'/main/a/';
        $data_array  = array();
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

        $total_records = $this->group_model->getTotal($s_name);
        $query = $this->group_model->getAll($s_name, $per_page, $lmt);

        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id'];
            $name           = $row['name'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);
            $edit_auth_href = site_url($path_uri . '/auth_pages_edit/' . $id);
            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'name'           => $name,
                'edit_href'      => $edit_href,
                'edit_auth_href' => $edit_auth_href,
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
        $this->parser->parse($template.'/group', $data);
        $this->global_libs->print_footer();
    }

    /**
     * add function
     */
    public function add()
    {
        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm() ) {
            $post = purify($this->input->post());

            $total = auto_inc('divisi');
            $iddivisi = "D".sprintf("%02d", $total);

            $data_post = array(
                'name'     => $post['name'],
                'is_admin' => (isset($post['is_admin']) && $post['is_admin'] == 1) ? 1 : 0,
                'iddivisi' => $iddivisi
            );

            $arrDivisi = array('iddivisi' => $iddivisi,
                'nama' => $post['name'],
                'status' => 'aktif');
            $divisi = $this->divisi_model->insert($arrDivisi);

            // insert data
            $id = $this->group_model->insert($data_post);

            $this->session->set_flashdata('success_msg', $this->title . ' has been added');

            redirect($this->path_uri);
        }
        $this->getForm();
    }

    /**
     * edit page
     * @param int $get_id
     */
    public function edit($id)
    {
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id) ) {
            $post = purify($this->input->post());

            $data_post = array(
                'name'     => $post['name'],
                'is_admin' => (isset($post['is_admin']) && $post['is_admin'] == 1) ? 1 : 0,
            );

            $arrDivisi = array('nama' => $post['name']);
            $result = $this->divisi_model->update($post['iddivisi'], $arrDivisi);

            // update data
            $this->group_model->update($id, $data_post);

            $this->session->set_flashdata('success_msg', $this->title . ' has been updated');

            if ($this->session->userdata('referrer') != '') {
                redirect($this->session->userdata('referrer'));
            } else {
                redirect($this->path_uri);
            }
        }
        $this->getForm($id);
    }

    /**
     * delete page
     */
    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if ( (ctype_digit($this->input->post('id'))) && ($this->input->post('id')>0)) {
                if (auth_access_validation(adm_sess_usergroupid(), $this->ctrl)) {
                    if ($this->input->post('id') != adm_sess_usergroupid()) {
                        $id = $this->input->post('id');
                        $this->group_model->delete($id);
                        $this->group_model->deleteAuthGroup($id);

                        $this->session->set_flashdata('success_msg',$this->title.' (s) has been deleted.');
                    } else {
                        $this->session->set_flashdata('error_msg','Delete failed. You can\'t delete your own Group.');
                    }
                } else {
                    $this->session->set_flashdata('error_msg','You can\'t manage this content.<br/>');
                }
            } else {
                $this->session->set_flashdata('error_msg','Delete failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_msg','Delete failed. Please try again.');
        }
    }

    public function search()
    {
        $s_name = $this->input->post('s_name');

        redirect($this->template.'/main/a' . $s_name);
    }

    ///////// ACL /////////
    /**
     * acl page
     * @param int $get_id
     */
    public function auth_pages_edit($id = 0)
    {
            if (!$id) {
                $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
                redirect($this->template);
            }

            if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateFormAuth() ) {
                $post = purify($this->input->post());

                $this->group_model->deleteAuthGroup($id);

                for ($a=0; $a<count($post['auth_admin']); $a++) {
                    $data_post[$a] = array(
                        'menu_id'  => $post['auth_admin'][$a],
                        'group_id' => $id,
                    );
                    // update data
                    $this->group_model->insertAuthGroup($data_post[$a]);
                }

                $this->session->set_flashdata('success_msg','Group Authentication has been updated');

                redirect($this->template);
            }
            $this->getFormAuth($id);
    }


    /////////////////////////////////////////////////////////////////
    /////////////////////////// private /////////////////////////////
    /////////////////////////////////////////////////////////////////

    /**
     * get form
     * @param int $id
     */
    private function getForm($id = 0)
    {
        $this->global_libs->print_header();

        $menu_title	= $this->title;
        $file_app	= $this->ctrl;
        $path_app	= $this->path;
        $path_uri	= $this->path_uri;
        $template	= $this->template;
        $id		    = (int)$id;
        $error_message	= array();
        $post		= array();
        $cancel_btn = site_url($path_uri);

        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->group_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
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
        } else {
            $breadcrumbs[] = array(
                'text'  => 'Add',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/add');
        }

        // set error
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }
        if (isset($this->error['name'])) {
            $error_message['name'] = alert_box($this->error['name'], 'error');
        } else {
            $error_message['name'] = '';
        }

        // set value
        if ($this->input->post('name') != '') {
            $post['name'] = $this->input->post('name');
        } elseif ((int)$id>0) {
            $post['name'] = $row['name'];
        } else {
            $post['name'] = '';
        }
        if ($this->input->post('is_admin') != '') {
            $post['is_admin'] = 'checked';
        } elseif ((int)$id>0) {
            $post['is_admin'] = ($row['is_admin']) ? 'checked' : '';
        } else {
            $post['is_admin'] = '';
        }
        if ($this->input->post('iddivisi') != '') {
            $post['iddivisi'] = $this->input->post('iddivisi');
        } elseif ((int)$id>0) {
            $post['iddivisi'] = $row['iddivisi'];
        } else {
            $post['iddivisi'] = '';
        }

        $post = array($post);
        $error_message = array($error_message);

        $data = array(
            'base_url'    => base_url(),
            'menu_title'  => $menu_title,
            'post'        => $post,
            'action'      => $action,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn,
        );

        $this->parser->parse($template . '/group_form', $data);
        $this->global_libs->print_footer();
    }

    /**
     * validate form group admin
     * @param int $id
     * @return bool true / false $this->error
     */
    private function validateForm($id = 0)
    {
        $post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        if ($post['name'] == '') {
            $this->error['name'] = 'Please insert Group Name.<br/>';
        } else {
            if (strlen($post['name']) < 3) {
                $this->error['name'] = 'Group Name length must be at least 3 character(s).<br/>';
            } else {
                if(!$this->group_model->CheckExistsAdminGroup($post['name'],$id)) {
                    $this->error['name'] = 'Admin Group Name already exists, please input different Group Name.<br/>';
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get form acl
     * @param int $id
     */
    private function getFormAuth($id=0)
    {
        $this->global_libs->print_header();

        $menu_title  = $this->title;
        $file_app    = $this->ctrl;
        $path_uri    = $this->path_uri;
        $path_app    = $this->path;
        $template    = $this->template;
        $id          = (int)$id;
        $error_message   = array();
        $cancel_btn  = site_url($path_uri);
        $breadcrumbs = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        $breadcrumbs[] = array(
            'text'   => 'Edit Auth Group',
            'href'   => '#',
            'class'  => 'class="current"'
        );

        $action = site_url($path_uri . '/auth_pages_edit/' . $id);

        $auth_list = $this->getParentAdminMenu($id);

        // set error
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }
        if (isset($this->error['auth_admin'])) {
            $error_message['auth_admin'] = alert_box($this->error['auth_admin'], 'error');
        } else {
            $error_message['auth_admin'] = '';
        }

        $error_message = array($error_message);

        $data = array(
            'base_url' 		=> base_url(),
            'menu_title'	=> $menu_title,
            'auth_list' 	=> $auth_list,
            'action' 		=> $action,
            'error_msg'		=> $error_message,
            'breadcrumbs'	=> $breadcrumbs,
            'file_app'		=> $file_app,
            'path_app'		=> $path_app,
            'path_uri'		=> $path_uri,
            'cancel_btn'	=> $cancel_btn,
        );
        $this->parser->parse($template.'/auth_pages_form', $data);
        $this->global_libs->print_footer();
    }

    /**
     *
     * @return bool $this->error
     */
    private function validateFormAuth()
    {
        $post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        if ($post['auth_admin'] == '') {
            $this->error['auth_admin'] = 'Please select Authentication Group.<br/>';
        } else {
            if (count($post['auth_admin']) == 0) {
                $this->error['auth_admin'] = 'Please select Authentication Group.<br/>';
            } else {
                foreach($post['auth_admin'] as $row) {
                    if (!ctype_digit($row)) {
                        $this->error['auth_admin'] = 'Please select correct Authentication Group.<br/>';
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

    /**
     * parent menu selector
     * @param int $parent
     * @param string $prefix
     * @param int $id_group
     * @return option list of admin menu
     */
    private function getParentAdminMenu($id_group, $is_group_superadmin=0, $parent=0, $prefix='')
    {
        $tmp_menu = '';
        $query = $this->group_model->getAllAdminMenu($parent,$is_group_superadmin);
        if ($query->num_rows()>0) {
            foreach ($query->result_array() as $row) {
                $tree = $selected = '';
                $divider = '<span class="span-taxo">&nbsp;</span>';
                $id_auth_pages = $this->group_model->getAuthPages($id_group, $row['id']);
                if ($id_auth_pages) {
                    $selected = 'checked="checked"';
                }
                if ($parent != 0) {
                    $tree = 'style="margin-left: 25px"';
                }
                $tmp_menu .=  '<div class="checkbox" '. $tree .'><label><input type="checkbox" value="'.$row['id'].'" '.$selected.'" name="auth_admin[]">'.$row['name'].'</label></div>' . "\n";

               $tmp_menu .=  $this->getParentAdminMenu($id_group,$is_group_superadmin,$row['id'], $prefix.$divider);
            }
        }
        return $tmp_menu;
    }
}
