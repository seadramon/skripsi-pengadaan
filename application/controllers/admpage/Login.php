<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->folder   = admin_folder();
        $this->ctrl     = 'login';
        $this->template = admin_folder() . '/layout';
        $this->path     = base_url() . admin_folder() . '/login';
        $this->path_uri = admin_folder() . '/login';
        $this->title    = 'Login';
    }

    public function index() {
        admin_is_loged();
        $error_login = ($this->session->flashdata('error_login') != '') ? $this->session->flashdata('error_login') : '';
        $data = array(
            'base_url'    => base_url(),
            'login'       => '',
            'password'    => '',
            'error_login' => $error_login,
            'footer_text' => sprintf(get_setting('app_footer'),date('Y')),
            'head_title'  => $this->title.' - '.get_setting('app_title')
        );
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->auth->login($this->input->post('email'), 
                               $this->input->post('password'));
        }
        
        $this->load->view($this->template . '/login', $data);
    }
    
    public function log_in() {
        $this->index();
    }

    /**
     * logout page
     */
    public function logout() {
        $this->auth->logout();
        redirect($this->path_uri);
    }
}
