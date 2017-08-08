<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
    public function __construct()
    {
        $this->load->model('auth_model');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     **/
    public function __call($method, $arguments)
    {
        if (!method_exists( $this->auth_model, $method) )
        {
            throw new Exception('Undefined method Auth::' . $method . '() called');
        }

        return call_user_func_array( array($this->auth_model, $method), $arguments);
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function forgotten_password($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('auth_user');

        if ($query->num_rows() > 0) {
            $user = $query->row();
            $reset_code = md5($user->email . time());

            $this->db->where('email', $user->email);
            $this->db->update('auth_user', array('reset_code' => $reset_code));

            $data = array(
                'name'  => $user->name,
                'email' => $user->email,
                'link'  => base_url() . 'admpage/reset_password?email='. $user->email .'&code='. $reset_code,
            );

            $message = $this->load->view('email/reset_password', $data, true);

            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);

            $this->email->from('no-reply@rakernasbca.com', 'Rakernas BCA 2015');
            $this->email->to($user->email);

            $this->email->subject('Reset Password Rakernas BCA 2015');
            $this->email->message($message);

            $this->email->send();

            return true;
        }

        return false;
    }

    public function register($email)
    {
        $this->db->where('email', $email);
        $this->db->where('group_id', 3);
        $user = $this->db->get('auth_user')->row();

        if ($user == null || $user->is_registered == 1) {
            return false;
        } else {
            $password = $this->phpass->hash('bca' . $user->nik);

            $this->db->where('id_auth_user', $user->id_auth_user);
            $this->db->update('auth_user', ['is_registered' => 1, 'password' => $password]);

            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'bca' . $user->nik,
            );

            $message = $this->load->view('email/register', $data, true);

            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);

            $this->email->from('no-reply@rakernasbca.com', 'Rakernas BCA 2015');
            $this->email->to($user->email);

            $this->email->subject('Registrasi Rakernas BCA 2015');
            $this->email->message($message);

            $this->email->send();

            return true;
        }
    }

    /**
     * logout
     *
     * @return boolean
     * @author Mathew
     **/
    public function logout()
    {

        //delete the remember me cookies if they exist
//        if (get_cookie($this->config->item('identity_cookie_name', 'auth')))
//        {
//            delete_cookie($this->config->item('identity_cookie_name', 'auth'));
//        }
//        if (get_cookie($this->config->item('remember_cookie_name', 'auth')))
//        {
//            delete_cookie($this->config->item('remember_cookie_name', 'auth'));
//        }

        //Destroy the session
//        $this->session->unset_userdata();
        $this->session->sess_destroy();

        //Recreate the session
        if (substr(CI_VERSION, 0, 1) == '2')
        {
            $this->session->sess_create();
        }
        else
        {
            $this->session->sess_regenerate(TRUE);
        }

        return true;
    }
}