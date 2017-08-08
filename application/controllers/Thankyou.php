<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Thankyou extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($prize = "")
    {
		$data = array('prize' => $prize);
        $this->load->view('frontend/thankyou', $data);
    }


}
?>
