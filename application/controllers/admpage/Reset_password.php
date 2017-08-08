<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_password extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $get = $this->input->get();
        if (isset($get['email']) && isset($get['code'])) {
            $user = $this->db->get_where('auth_user', array('email' => $get['email']));

            if ($user->num_rows() > 0) {
                $user = $user->row();

                if($user->reset_code == $get['code']) {
                    $data = array(
                        'email' => $user->email,
                    );

                    $this->load->view('forgot_password', $data);
                } else {
                    echo 'Your link is expired. Please try again.';
                }
            }
        } else {
            echo 'Error occoured while processing';
        }
    }

    public function act() {
        $post = $this->input->post();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($post['password']) && isset($post['pass_conf']) && $post['password'] != '' && $post['pass_conf'] != '' ) {
            $this->db->where('email', $post['email']);
            $query = $this->db->get('auth_user');

            if($query->num_rows() > 0) {
                if($post['password'] == $post['pass_conf']) {
                    $password = $this->phpass->hash($post['password']);
                    $data = [
                        'password'   => $password,
                        'reset_code' => '',
                    ];
                    $this->db->where('email', $post['email']);
                    $this->db->update('auth_user', $data);

                    $this->load->view('reset_pass_success');
                }else {
                    echo 'error|Password not match with passconf', exit;
                }
            }else {
                echo 'error|Email not in our database', exit;
            }
        }else {
            echo 'error|Please try with the right method!',exit;
        }
    }
}