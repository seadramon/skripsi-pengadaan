<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Backend_Controller {

    public function __construct()
    {
        parent::__construct();
        auth_admin();

        $this->load->model(admin_folder().'/user_model');
    }

    public function index()
    {
        $this->global_libs->print_header();
        $data = array(
            'day'               => date('l'),
            'date'              => date('d F Y'),
            'hide'              => '',
            'admin_name'        => $this->session->userdata('ADM_SESS')['nama'],
        );

        $data['app_title'] = get_setting('app_title');
        $data['user'] = $this->user;
        $data['all'] = $this->user_model->get($this->user['nik'])->row_array();

        $this->load->view(admin_folder() . '/layout/home', $data);
    }
}
