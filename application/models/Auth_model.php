<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    // error login admin message
    private $err_login_adm;
    private $user_table;
    private $group_table;

    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->user_table = 'karyawan';
        $this->group_table = 'group';
        $this->err_login_adm = 'Username or Password is incorrect';
        $this->err_permission = 'You don\'t have permission to access this page';
    }

    /**
     * check login admin
     * @param type $email
     * @param type $password 
     */
    function login($email, $password)
    {
        if ($email != '' && $password != '') {
                $email = strtolower($email);

                $this->db->where('email', $email);
                $this->db->where('status', 'aktif');
                $query = $this->db->get('karyawan');

                if ($query->num_rows() > 0) {
                    $row = $query->row();

                    //TODO Delete these lines after figuring out How to login user properly
    //                if ($row->group_id == 3) {
    //                    $this->session->set_flashdata('error_login', $this->err_permission);
    //                    redirect(admin_folder() . '/login');
    //                }

                    if ($this->phpass->check($password, $row->password)) {

                        $user_sess = array(
                            'nama'       => $row->nama,
                            'nik'        => $row->nik,
                            'group_id'   => $row->group_id,
                            'iddivisi'   => $row->iddivisi,
                            'email'      => $row->email,
                            'url'        => base_url(),
                            'ip_address' => $this->input->ip_address()
                        );
                        $this->session->set_userdata('ADM_SESS', $user_sess);
                        $this->session->set_userdata('nik', $row->nik);
                        
                        if ($this->session->userdata('tmp_login_redirect') != '' || $this->session->userdata('tmp_login_redirect')!=null) {
                            redirect($this->session->userdata('tmp_login_redirect'));
                        } else {
                            redirect(admin_folder() . '/home');
                        }
                    } else {
                        $this->session->set_flashdata('error_login', $this->err_login_adm);
                        redirect(admin_folder() . '/login');
                    }
                } else {
                    $this->session->set_flashdata('error_login', $this->err_login_adm);
                    redirect(admin_folder() . '/login');
                }
        } else {
            $this->session->set_flashdata('error_login', $this->err_login_adm);
            redirect(admin_folder() . '/login');
        }
    }

    public function update($id, array $data)
    {
        if (array_key_exists('password', $data)) {
            if( ! empty($data['password'])) {
                $data['password'] = $this->phpass->hash($data['password']);
            } else {
                // unset password so it doesn't effect database entry if no password passed
                unset($data['password']);
            }
        }

        $this->db->where('nik', $id);
        $this->db->update($this->user_table);

        return true;
    }

    /**
     * Checks username
     *
     * @return bool
     * @author Mathew
     **/
    public function username_check($username = '')
    {
        if (empty($username)) {
            return false;
        }

        return $this->db->where('username', $username)
            ->count_all_results($this->user_table) > 0;
    }

    /**
     * Checks email
     *
     * @return bool
     * @author Mathew
     **/
    public function email_check($email = '')
    {
        if (empty($email)) {
            return false;
        }

        return $this->db->where('email', $email)
            ->count_all_results($this->user_table) > 0;
    }

    /**
     * user
     *
     * @return object
     * @author Ben Edmunds
     **/
    public function user($id = null)
    {
        //if no id was passed use the current users id
        $id || $id = $this->session->userdata('nik');

        $this->db->limit(1);
        $this->db->where('nik', $id);

        $query = $this->db->get($this->user_table);

        return $query;
    }

    public function backend_access($id)
    {
        $this->db->select($this->group_table . '.is_admin');
        $this->db->where($this->user_table . '.nik', $id);
        $this->db->join($this->group_table, $this->user_table . '.group_id = ' . $this->group_table . '.id');
        $query = $this->db->get($this->user_table)->row();

        return (bool) $query->is_admin;
    }
	
}
