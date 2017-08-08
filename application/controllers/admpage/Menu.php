<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
    private $error = array();
    private $folder;
    private $ctrl;
    private $template;
    private $path;
    private $path_uri;
    private $title;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        auth_admin();
        $this->load->model(admin_folder() . '/menu_model');
        
        $this->folder			= admin_folder();
        $this->ctrl 			= 'menu';
        $this->path_uri 		= admin_folder() . '/menu';
        $this->template 		= admin_folder() . '/menu';
        $this->path 			= base_url() . admin_folder().'/menu';
        $this->title			= get_admin_menu_title('menu');
        $this->id_menu_admin    = get_admin_menu_id('menu');
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

        $s_name       = $this->uri->segment(4);
        $pg            = $this->uri->segment(5);
        $per_page      = 10;
        $uri_segment   = 5;
        $no            = 0;
        $path          = $this->path . '/main/a/';
        $data_arr      = array();
        $folder        = $this->folder;
        $menu_title    = $this->title;
        $file_app      = $this->ctrl;
        $path_app      = $this->path;
        $path_uri      = $this->path_uri;
        $template      = $this->template;
        $breadcrumbs   = array();
        $add_btn       = site_url($path_uri.'/add');
        
        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);
        
        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => '#',
                'class' => 'class="current"'
        );

        if (strlen($s_name) > 1) $s_name = substr($s_name,1);
        else $s_name = '';


        if ($s_name) {
            $path = str_replace('/a','/a'.$s_name,$path);
        }

        if (!$pg) {
            $lmt = 0;
            $pg = 1;
        } else {
            $lmt = $pg;
        }
        $no = $lmt;

        $total_records = $this->menu_model->getTotalAdminMenu($s_name);
        $query = $this->menu_model->getAllAdminMenu($s_name, $lmt, $per_page);

        foreach ($query->result_array() as $row) {
            $no++;
            $id 	   = $row['id'];
            $parent_id = $row['parent_id'];
            $name      = $row['name'];
            $edit_href = site_url($path_uri . '/edit/' . $id);

            $urut = $row['urut'];

            $last_urut 	= $this->menu_model->GetRefUrutMax();
            $first_urut = $this->menu_model->GetRefUrutMin();

            $parent_name = $this->menu_model->getParentNameById($parent_id);

            // get sorting
            $sort_up = $sort_down = '';
            if ($s_name == '') {
                if ($total_records == 1) {
                    $sort_up = $sort_down = '';
                } elseif ($last_urut == 1) {
                    $sort_up = $sort_down = '';
                } else {
                    if($urut == 1 && $pg==1) 
                        $sort_down = sort_arrow($id, $urut, $parent_id, $path_app, 'down');
                    elseif($urut == $first_urut) 
                        $sort_down = sort_arrow($id, $urut, $parent_id, $path_app, 'down');
                    elseif($urut == $last_urut) 
                        $sort_up = sort_arrow($id, $urut, $parent_id, $path_app, 'up');
                    elseif($no == $total_records) 
                        $sort_up = sort_arrow($id, $urut, $parent_id, $path_app, 'up');
                    else {
                        $sort_up = sort_arrow($id, $urut, $parent_id, $path_app, 'up');
                        $sort_down = sort_arrow($id, $urut, $parent_id, $path_app, 'down');
                    }
                }
            }

            $data_arr[] = array(
                'no'        => $no,
                'id'        => $id,
                'parent'    => $parent_name,
                'parent_id' => $parent_id,
                'name'      => $name,
                'edit_href' => $edit_href,
                'sort_down' => $sort_down,
                'sort_up'   => $sort_up,
            );
        }

        // paging
        $paging = global_paging($total_records, $per_page, $path, $uri_segment);
        if (!$paging) $paging = '<ul class="pagination"><li class="current"><a>1</a></li></ul>';
        //end of paging

        $error_message = alert_box($this->session->flashdata('error_msg'), 'error');
        $success_msg   = alert_box($this->session->flashdata('success_msg'), 'success');
        $info_msg      = alert_box($this->session->flashdata('info_msg'), 'warning');

        $data = array(
            'base_url'    => base_url(),
            'current_url' => current_url(),
            'menu_title'  => $menu_title,
            'data' 	      => $data_arr,
            's_name'      => $s_name,
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
        $this->parser->parse($template . '/menu', $data);
        $this->global_libs->print_footer();
    }

    /**
     * add page
     */
    public function add()
    {
        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm() ) {
            $post = purify($this->input->post());
            
            $data_post = array(
                'parent_id' => $post['parent_id'],
                'name'      => $post['name'],
                'file'      => strtolower($post['file']),
                'icon'      => $post['icon'],
            );

            $last_urut 	= $this->menu_model->GetRefUrutMax();
            $urut 		= $last_urut + 1;
            $data_urut 	= array('urut' => $urut);
            $data 		= array_merge($data_post, $data_urut);

            // insert data
            $id = $this->menu_model->insert($data);

            // update auth for developers
            $this->load->model(admin_folder() . '/group_model');
            $auth = array(
                'menu_id'  => $id,
                'group_id' => 1,
            );
            $this->group_model->insertAuthGroup($auth);

            $this->session->set_flashdata('success_msg', $this->title.' has been added');

            redirect($this->template);
        }
        $this->getForm();
    }	

    /**
     * edit page
     * @param int $get_id 
     */
    public function edit($get_id=0)
    {
        if (!$this->menu_model->CheckAdminMenuByGroupId(adm_sess_usergroupid(), $get_id)) {
            $this->session->set_flashdata('info_msg', 'You don\'t have access to change this menu.');
            if ($this->session->userdata('referrer') != '') {
                redirect($this->session->userdata('referrer'));
            } else {
                redirect($this->path_uri);
            }
        }

        $id = (int)$get_id;

        if (!$id) {
            $this->session->set_flashdata('error_msg','Please try again with the right method.');
            redirect($this->path_uri);
        }

        if (($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id)) {
            $post = purify($this->input->post());
            
            $data_post = array(
                'parent_id'	    => $post['parent_id'],
                'name'			=> $post['name'],
                'file'			=> strtolower($post['file']),
                'icon'			=> $post['icon'],
            );

            // update data
            $this->menu_model->UpdateAdminMenu($id, $data_post);

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
     * search page
     */
    public function search()
    {
        $s_name = trim($this->input->post('s_name'));
        redirect($this->template . '/main/a' . $s_name);
    }

    /**
     * change sort
     */
    public function change_sort()
    {
        if ($this->input->post('id')!='' && $this->input->post('parent_id')!='' && $this->input->post('urut')!='' && $this->input->post('direction')!='') {
            $id 		= $this->input->post('id');
            $parent_id 	= $this->input->post('parent_id');
            $urut 		= $this->input->post('urut');
            $direction 	= $this->input->post('direction');

            if( ( (ctype_digit($id)) && ($id > 0) ) && 
                    ( ctype_digit($parent_id) ) && 
                    ( (ctype_digit($urut)) && ($urut > 0 )) &&
                    ( $direction != '' )	 
            )
            {
                if ($this->menu_model->CheckAdminMenuByGroupId(adm_sess_usergroupid(), $id)) {
                    $this->menu_model->ChangeSort($id,$parent_id,$urut,$direction);

                    $this->session->set_flashdata('success_msg',$this->title.' has been sort '.$direction.'.');
                } else {
                    $this->session->set_flashdata('info_msg','You don\'t have access to change '.$this->title.'.');
                }
            } else {
                $this->session->set_flashdata('error_msg','Change sort failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_msg','Change sort failed. Please try again.');
        }
    }

    /**
     * delete page
     */
    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if ( (ctype_digit($this->input->post('id'))) && ($this->input->post('id')>0)) {
                if (auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
                    $id = (int)$this->input->post('id');
                    if ($this->menu_model->CheckAdminMenuByGroupId(adm_sess_usergroupid(),$id)) {
                        $this->menu_model->DeleteAdminMenu($id);

                        $this->session->set_flashdata('success_msg', $this->title.' (s) has been deleted.');
                    } else {
                        $this->session->set_flashdata('info_msg', 'You don\'t have access to delete '.$this->title.'.');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'You can\'t manage this content.<br/>');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
        }
    }
    
    
    /////////////////////////////////////////////////////////////////
    /////////////////////////// private /////////////////////////////
    /////////////////////////////////////////////////////////////////
    
    /**
     * get form
     * @param int $id 
     */
    private function getForm($id=0)
    {
        $this->global_libs->print_header();

        $menu_title		= $this->title;
        $file_app		= $this->ctrl;
        $path_app		= $this->path;
        $path_uri   	= $this->path_uri;
        $template		= $this->template;
        $id				= (int)$id;
        $error_message	= array();
        $post			= array();
        $cancel_btn     = site_url($path_uri);
        
        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);
        
        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );


        if ($id) {
            $query = $this->menu_model->GetAdminMenuById($id);
            if ($query->num_rows() > 0) {
                $admin_menu = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg','There is no record in our database.');
                redirect($template);
            }
        }

        if ($id) {
            $breadcrumbs[] = array(
                'text'   	=> 'Edit',
                'href'  	=> '#',
                'class'		=> 'class="current"'
            );
            $action = site_url($path_uri.'/edit/'.$id);
        } else {
            $breadcrumbs[] = array(
                'text'   	=> 'Add',
                'href'  	=> '#',
                'class'		=> 'class="current"'
            );
            $action = site_url($path_uri.'/add');
        }

        // set error
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }
        if (isset($this->error['parent_id'])) {
            $error_message['parent_id'] = alert_box($this->error['parent_id'], 'error');
        } else {
            $error_message['parent_id'] = '';
        }
        if (isset($this->error['menu'])) {
            $error_message['menu'] = alert_box($this->error['menu'], 'error');
        } else {
            $error_message['menu'] = '';
        }
        if (isset($this->error['file'])) {
            $error_message['file'] = alert_box($this->error['file'], 'error');
        } else {
            $error_message['file'] = '';
        }

        // set value
        if ($this->input->post('parent_id') != '') {
            $post['parent_id'] = $this->input->post('parent_id');
        } elseif ((int)$id>0) {
            $post['parent_id'] = $admin_menu['parent_id'];
        } else {
            $post['parent_id'] = 0;
        }
        
        if ($this->input->post('name') != '') {
            $post['name'] = $this->input->post('name');
        } elseif ((int)$id>0) {
            $post['name'] = $admin_menu['name'];
        } else {
            $post['name'] = '';
        }

        if ($this->input->post('file') != '') {
            $post['file'] = $this->input->post('file');
        } elseif ((int)$id>0) {
            $post['file'] = $admin_menu['file'];
        } else {
            $post['file'] = '';
        }

        if ($this->input->post('icon') != '') {
            $post['icon'] = $this->input->post('icon');
        } elseif ((int)$id>0) {
            $post['icon'] = $admin_menu['icon'];
        } else {
            $post['icon'] = '';
        }

        // generate menu parent
        $post['list_parent_option'] = $this->getParentSelect(0, '--', $post['parent_id'], $id);
        
        $post 		   = array($post);
        $error_message = array($error_message);

        $data = array(
            'base_url'    => base_url(),
            'menu_title'  => $menu_title,
            'post' 	      => $post,
            'action'      => $action,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn,
        );
        $this->parser->parse($template.'/menu_form', $data);
        $this->global_libs->print_footer();		
    }

    /**
     * form validation
     * @param int $id
     * @return int 
     */
    private function validateForm($id=0)
    {
        $id = (int)$id;
        $post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        if ($id) {
            if ($post['parent_id'] == $id) {
                $this->error['parent_id'] = 'Please set correct Parent.<br/>';
            }
        }

        if ($post['parent_id'] == '') {
            $this->error['parent_id'] = 'Please insert Parent.<br/>';
        }

        if (!ctype_digit($post['parent_id'])) {
            $this->error['parent_id'] = 'Please insert Parent.<br/>';
        }

        if ($post['name'] == '') {
            $this->error['name'] = 'Please insert Menu Title.<br/>';
        }

        if ($post['file'] == '') {
            $this->error['file'] = 'Please insert Menu File.<br/>';
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param int $parent
     * @param int $is_superadmin
     * @param string $prefix
     * @param int $selectitem
     * @param int $disable
     * @return string option list of admin menu 
     */
    private function getParentSelect($parent, $prefix='', $selectitem='',$disable='') {
        $tmp_menu = '';
        $this->load->model(admin_folder().'/menu_model');
        $query = $this->menu_model->getAdminMenuList($parent);
        foreach ($query->result_array() as $row) 
        {
            if ($disable > 0) {
                if($row['id'] == $disable) {
                    $tmp_menu .=  '';
                } elseif($row['parent_id'] == $disable) {
                    $tmp_menu .=  '';
                } else {
                    if ($selectitem == $row['id']) {
                        $tmp_menu .=  '<option value="'.$row['id'].'" selected="selected">'.$prefix.' '.$row['name'].'</option>';
                    } else { 
                        $tmp_menu .=  '<option value="'.$row['id'].'">'.$prefix.' '.$row['name'].'</option>';
                    }
                }
                //$tmp_menu .= '';
            } else {
                if ($selectitem == $row['id']) {
                    $tmp_menu .=  '<option value="'.$row['id'].'" selected="selected">'.$prefix.' '.$row['name'].'</option>';
                } else { 
                    $tmp_menu .=  '<option value="'.$row['id'].'">'.$prefix.' '.$row['name'].'</option>';
                }
            }
            $tmp_menu .=  $this->getParentSelect($row['id'], $prefix.'--',$selectitem,$disable);
        }
        return $tmp_menu;
    }
    
}
