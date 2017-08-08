<?php 
/**
* 
*/
class Frontauth_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->err_login = 'Email atau Password salah';
        $this->err_permission = 'You don\'t have permission to access this page';
	}

	public function login($email, $password)
	{
		if ($email!='' && $password!='') {
			$rolenya = $this->db->get_where('user', array('email' => $email))->row('role');
			if ($email=='damar@bantuin.id' || $rolenya=='admin') {
				$this->session->set_flashdata('error_login', $this->err_permission);
            	redirect(base_url() . 'users/login');
			}

			$this->db->where('email', $email);
			$this->db->where('password', md5($password));
			$query = $this->db->get('user');

			if ($query->num_rows() > 0) {
				$row = $query->row();

				// admin cannot access frontend
				// print_r($row->role);die();
				if ($row->role=='admin') {
					$this->session->set_flashdata('error_login', $this->err_permission);
            		redirect(base_url() . 'users/login');
				}

				// Entitas turunan dari User
				$this->db->where('id_user', $row->id_user);
        		$child = $this->db->get($row->role)->row_array();

        		if (is_array($child) && count($child) > 0) {
	        		$arrUser = array('id_user' => $row->id_user,
							'nama' 		 => $row->nama,
							'birth_date' => $row->birth_date,
							'email' 	 => $row->email,
							'phone' 	 => $row->phone,
							'alamat'     => $row->jk,
							'role'		 => $row->role);
	        		$this->session->set_userdata('user', $arrUser);

	        		// Organisasi dari entitas turunan
	        		$this->db->where('id_organisasi', isset($child['id_organisasi'])?$child['id_organisasi']:null);
	        		$org = $this->db->get('organisasi')->row_array();

	        		if (is_array($org) && count($org) > 0) {
	        			$arrOrg = array('id_organisasi' => $org['id_organisasi'],
	        						'nama' => $org['nama'],
	        						'email' => $org['email'],
	        						'alamat' => $org['alamat'],
	        						'phone' => $org['phone'],
	        						'postal' => $org['postal'],
	        						'pic' => $org['pic'],
	        						'file' => $org['file']);

						$this->session->set_userdata('org', $arrOrg);
	        		}
	        		// success and redirect
	        		if ($this->session->userdata('tmp_url')) {
	        			redirect($this->session->userdata('tmp_url'));
	        		} else {
	        			redirect(base_url() . 'home');
	        		}
	        	} else {
	        		$this->session->set_flashdata('error_login', $this->err_login);
            		redirect(base_url() . 'users/login');	
	        	}
			} else {
				$this->session->set_flashdata('error_login', $this->err_login);
            	redirect(base_url() . 'users/login');	
			}
		} else {
			$this->session->set_flashdata('error_login', $this->err_login);
            redirect(base_url() . 'users/login');
		}
	}

	function updateUser($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_user', $id);
            if ($this->db->update('user', $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function getUser($id = 0)
    {
        $this->db->where('id_user', $id);
        $query = $this->db->get('user');

        return $query;
    }
}
?>