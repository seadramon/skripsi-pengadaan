<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $user;

    function __construct()
    {
        parent::__construct();

        $this->user = $this->auth->user()->row_array();
    }
}

include_once( APPPATH . 'core/Backend_Controller.php' );
