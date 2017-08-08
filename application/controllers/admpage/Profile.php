<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
        $this->folder       = admin_folder();
        $this->ctrl         = 'profile';
        $this->template     = admin_folder() . '/profile';
        $this->path_uri     = admin_folder() . '/profile';
        $this->path         = site_url() . admin_folder() . '/profile';
        $this->title        = get_admin_menu_title('profile');
        $this->max_width    = 281;
        $this->max_height   = 392;
        $this->thumb_width  = 75;
        $this->thumb_height = 75;
        $this->thumb2_width = 150;
        $this->thumb2_height= 150;
        $this->path_pict    = './uploads/ava/';
        $this->id_menu_admin= get_admin_menu_id('profile');
        $this->is_superadmin= adm_is_superadmin(adm_sess_userid());
    }

    public function index()
    {
        $id = adm_sess_userid();


        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id) ) {

            $post = purify($this->input->post());

            $data_post = array(
                'name'    => $post['name'],
                'email'   => strtolower($post['email']),
            );

            if (($post['userpass'] != '') && (strlen($post['userpass']) >= 5)) {
                $pass = $this->phpass->hash($post['userpass']);
                $data_pass = array('password' => $pass);
                $data_post = array_merge($data_post, $data_pass);
            }

            if (!empty($_FILES['avatar']['tmp_name'])) {
                $filename = url_title($post['name']);
                $path_pic = "./uploads/ava/";

                $pic_foto = image_resize_to_folder($_FILES['avatar'], $path_pic, $filename, $this->max_width, $this->max_height);

                $data_pass2 = array('avatar' => $pic_foto);
                $data_post  = array_merge($data_post, $data_pass2);
            }
            
            // update data
            if ($this->user_model->updateUser($id, $data_post)) {
                $this->db->where('id', $this->session->userdata('ADM_SESS')['user_id']);
                $row = $this->db->get('user')->row();

                $user_sess = array(
                    'name'       => $row->name,
                    'user_id'    => $row->id,
                    'group_id'   => $row->group_id,
                    'email'      => $row->email,
                    'ip_address' => $this->input->ip_address(),
                );
                $this->session->set_userdata('ADM_SESS',$user_sess);
                $_SESSION['ADM_SESS']=$this->session->userdata('ADM_SESS');

                $this->session->set_flashdata('success_msg', 'Your profile has been successfully updated');
            } else {
                $this->session->set_flashdata('error_msg', 'Your profile failed to update');
            }

            redirect($this->path_uri);
        }
        $this->getForm($id);
    }

    /**
     * get print form
     * @param int $id
     */
    private function getForm($id=0)
    {
        $this->global_libs->print_header();

        $folder		= $this->folder;
        $menu_title	= $this->title;
        $file_app	= $this->ctrl;
        $path_app	= $this->path;
        $path_uri	= $this->path_uri;
        $template	= $this->template;
        $id		= (int)$id;
        $error_message	= array();
        $post           = array();
        $group_list	= '';
        $site_list	= '';
        $cancel_btn     = site_url($path_uri);
        $breadcrumbs    = array();
        $is_superadmin  = $this->is_superadmin;

        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
            'text'  => $menu_title,
            'href'  => site_url($path_uri),
            'class' => ''
        );

        if ($id) {
            $query = $this->user_model->get($id);
            if ($query->num_rows()>0) {
                $admin_info = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
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
            $required = '';
        } 

        // set error
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'],'warning');
        } else {
            $error_message['warning'] = '';
        }
        if (isset($this->error['id_user_sales'])) {
            $error_message['id_user_sales'] = alert_box($this->error['id_user_sales'],'error');
        } else {
            $error_message['id_user_sales'] = '';
        }

        if (isset($this->error['userpass'])) {
            $error_message['userpass'] = alert_box($this->error['userpass'],'error');
        } else {
            $error_message['userpass'] = '';
        }
        if (isset($this->error['name'])) {
            $error_message['name'] = alert_box($this->error['name'],'error');
        } else {
            $error_message['name'] = '';
        }
        if (isset($this->error['email'])) {
            $error_message['email'] = alert_box($this->error['email'],'error');
        } else {
            $error_message['email'] = '';
        }
        if (isset($this->error['phone'])) {
            $error_message['phone'] = alert_box($this->error['phone'],'error');
        } else {
            $error_message['phone'] = '';
        }

        // set value
        if ($this->input->post('name') != '') {
            $post['name'] = $this->input->post('name');
        } elseif ((int)$id>0) {
            $post['name'] = $admin_info['name'];
        } else {
            $post['name'] = '';
        }

        if ($this->input->post('email') != '') {
            $post['email'] = $this->input->post('email');
        } elseif ((int)$id>0) {
            $post['email'] = $admin_info['email'];
        } else {
            $post['email'] = '';
        }

        $post = array($post);
        $error_message = array($error_message);
        $success_msg = $this->session->flashdata('success_msg') != '' ? alert_box($this->session->flashdata('success_msg'), 'success') : '';

        $data = array(
            'base_url' =>base_url(),
            'menu_title'=>$menu_title,
            'post' => $post,
            'error_msg'=> $error_message,
            'success_msg'=> $success_msg,
            'breadcrumbs'=>$breadcrumbs,
            'file_app'=> $file_app,
            'path_app'=> $path_app,
            'cancel_btn'=> $cancel_btn,
        );

        $this->parser->parse($template.'/edit_profile.html', $data);
        $this->global_libs->print_footer();
    }

    /**
     *
     * @param int $id
     * @return string $this->error error
     */
    private function validateForm($id=0)
    {
        $id = (int)$id;
        $post = purify($this->input->post());

        if ($post['name'] == '') {
            $this->error['name'] = 'Please insert Name.<br/>';
        } else {
            if ((strlen($post['name']) < 1) || (strlen($post['name']) > 32)) {
                $this->error['name'] = 'Please insert Name.<br/>';
            }
        }

        if ($post['email'] == '') {
            $this->error['email'] = 'Please insert Email.<br/>';
        } else {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error['email'] = 'Please insert correct Email.<br/>';
            }
        }

        if ($id) {
            if ($post['userpass'] != '') {
                if ($post['userpass'] != $post['confpass']) {
                    $this->error['userpass'] = 'Confirm Password didn\'t match with New Password.<br/>';
                } else {
                    if (strlen($post['userpass']) < 5) {
                        $this->error['userpass'] = 'Password length must be at least 5 character(s).<br/>';
                    }
                }
            }
        } else {
            if ($post['userpass'] == '') {
                $this->error['userpass'] = 'Please insert Password.<br/>';
            } else {
                if (strlen($post['userpass']) < 5) {
                    $this->error['userpass'] = 'Password length must be at least 5 character(s).<br/>';
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}