<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /*************************************
  * Global API  Model Class
  * @Author : Latada
  * @Email  : mac_ [at] gxrg [dot] org
  * @Type 	: Model
  * @Desc 	: Global API model
  ***********************************/
class Api_model extends CI_Model {
    
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
	/* Check User Login 
	 * @param string $uname
	 * @param string $pass
	 * @return false on failure or detail info user on success
	 */
	function check_login($email,$pass) {
		$email = strtolower($email);
        $this->db->where('email', $email);
        $query = $this->db->get('user');
            if ($query->num_rows() > 0) {
                $row = $query->row_array(); 
				$this->load->library('encrypt');
                $userpass = $this->encrypt->decode($row['userpass']);
                if ( ($pass == $userpass) && ($pass != "") ) {
					# insert to log
                    $data = array(
                        'id_user'=>$row['id'],
                        'action'=>'Login',
                        'desc'=>'Login:succeed; IP:'.$_SERVER['SERVER_ADDR'].'; email:'.$email.';',
                        'create_date'=>date('Y-m-d H:i:s'),
                    );

                    insert_to_log($data);

					if($row['avatar'] != '') {
						$row['avatar'] = ( file_exists('./uploads/ava/'.$row['avatar'])) ? base_url() . 'uploads/ava/'.$row['avatar'] : '';
						
					} else {
						$row['avatar'] = '';
					}
					$row['id_user_sales'] = $row['id'];
					$return = $row;
                } else {
                    # insert to log
                    $data = array(
                        'id_user'=>0,
                        'action'=>'Login',
                        'desc'=>'Login:failed; IP:'.$_SERVER['SERVER_ADDR'].'; email:'.$email.';',
                        'create_date'=>date('Y-m-d H:i:s'),
                    );
                    insert_to_log($data);
					$return = false;
                }
            } else {
                #insert to log
                $data = array(
                    'id_user'=>0,
                    'action'=>'Login',
                    'desc'=>'Login:failed; IP:'.$_SERVER['SERVER_ADDR'].'; email:'.$email.';',
                    'create_date'=>date('Y-m-d H:i:s'),
                );
                insert_to_log($data);
				$return = false;
            }
        
		return $return;
	}
	
	/* Check whether user logging in or not
	 * @param string $uname
	 * @return false on failure or true on success
	 */
	function is_login($uname) {
		return ($uname && $this->db->get_where('user',array('is_logged_in'=>1,'username' => strtolower($uname)))->num_rows()>0) ? 'true' : 'false';
	}
	
	/* Logout user 
	 * @param string $uname
	 * @return void
	 */
	function logout($uname) {
		$usr = $this->db->get_where('user',array('username' => $uname,'is_logged_in' => 1));
		if($usr->num_rows()>0) {
			$usr = $usr->row();
			$this->db->where('id_user',$usr->id_user)->update('user',array('is_logged_in'=>0));
		}
	}
	
	/**
	 * Register user
	 * @param array $data
	 * @return void
	 */
	function regist($data) {
		$this->db->insert('user',$data);
	}
	
	/**
	 * Fetching user data profile 
	 * @param array $data
	 * @return array user profile on success or false on failure
	 */
	function fetch_user_profile($data) {
		// $data['is_logged_in'] = 1;
		$data = array('username' => $data);
		$profile = $this->db->get_where('user',$data);
		if($profile->num_rows()>0) {
			$profile = $profile->row_array();
		}else {
			$profile = false;
		}
		return $profile;
	}
	
	/**
	 * Fetching client data
	 * @param void
	 * @return array multiple client on success or false on failure
	 */
	function fetch_all_client() {
		$escape_char = ', ';
		$clients = $this->db->from('clients')
							->where("publish = 1")
							->get();
		if($clients->num_rows()>0) {
			$clients = $clients->result_array();
			
			// $clients = $clients->row_array();
		}else {
			$clients = false;
		}
		return $clients;
	}
	
}
    