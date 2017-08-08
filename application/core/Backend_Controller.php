<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        // var_dump($this->user);die();

        if (! $this->auth->backend_access($this->user['nik'])) {
            $this->session->set_flashdata('error_login', 'You don\'t have permission to access this page.');
            redirect(admin_folder() . '/login');
        }
    }
}