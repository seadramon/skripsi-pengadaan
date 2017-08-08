<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * retrieve user all user admin
     * @param type $search1
     * @param type $search2
     * @param type $limit
     * @param type $per_pg
     * @return type string $query
     */
    function GetAllUsersAdmin($search1=null,$search2=null,$search3=0,$limit=0,$per_pg=0)
    {
        if ($search1 != null) $this->db->where("LCASE(name) LIKE '%".utf8_strtolower($search1) . "%'");
        if ($search2 != null) $this->db->where("LCASE(email) LIKE '%".utf8_strtolower($search2) . "%'");
        if ($search3 != 1) $this->db->where('is_superadmin',0);
        $this->db->where('group_id <>', 3);
        $this->db->limit($per_pg,$limit);
        $query = $this->db->get('users');
        return $query;
    }
    /**
     *
     * @param int $id
     * @return bool 
     */
    function check_is_superadmin($id, $is_super_admin) {
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $this->db->limit(1);
        $query = $this->db->get('users');
        if ($query->num_rows()>0) {
            $row = $query->row_array();
            if ($is_super_admin == 1) {
                return true;
            } else {
                if ($row['is_superadmin'] == 0 && $is_super_admin == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * count total user admin
     * @param type $search1
     * @param type $search2
     * @return type integer count total rows
     */
    function TotalUserAdmin($search1=null,$search2=null,$search3=0)
    {
        $this->db->select('count(*) as total');
        if ($search1 != null) $this->db->where("LCASE(name) LIKE '%".utf8_strtolower($search1) . "%'");
        if ($search2 != null) $this->db->where("LCASE(email) LIKE '%".utf8_strtolower($search2) . "%'");
        if ($search3 != 1) $this->db->where('is_superadmin',0);
        $query = $this->db->get('users');
        if ($query->num_rows()>0)
        {
            $row = $query->row_array();
            return $row['total'];
        }
        else
        {
            return '0';
        }
    }
	function TotalClient($search1=null,$search2=null,$search3=null,$search4=null,$search5=null)
    {
        if($search3 != '0' && $search3 != null)
		{
				$this->db->where("type ='".$search3."'");
				if($search3 == '2')
				{
					if ($search2 != null) $this->db->where("ucid_lv_a LIKE '%".utf8_strtolower($search2) . "%'");
					if ($search4 != null) $this->db->where("iata LIKE '%".utf8_strtolower($search4) . "%'");
				}
				if($search3 == '1')
				{
					if ($search2 != null) $this->db->where("ucid LIKE '%".utf8_strtolower($search2) . "%'");
				}
		}
		if ($search1 != null) $this->db->where("long_name LIKE '%".utf8_strtolower($search1) . "%'");
		if ($search5 != null && $search5 != '0') $this->db->where("city = '".utf8_strtolower($search5)."'");
		$query = $this->db->get('clients');
        if ($query->num_rows()>0)
        {
            $row = $query->num_rows();
            return $row;
        }
        else
        {
            return '0';
        }
    }
    /**
     * get group name by id group
     * @param type $id_group
     * @return type string group name
     */
    function GetGroupNameById($group_id)
    {
        $this->db->where('id', $group_id);
        $this->db->limit(1);
        $query = $this->db->get('groups');
        if ($query->num_rows()>0) {
            $row = $query->row_array();
            return $row['name'];
        } else {
            return '--';
        }
    }

    /**
     * list of user admin group
     * @return type string $query
     */
    function ListUsersGroup($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $this->db->order_by('name','asc');
        $query = $this->db->get('users');
        return $query;
    }

    function listAdmin()
    {
        $this->db->where('group_id', 1);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('users');
        return $query;
    }

    function ListUserAdminGroup()
    {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('groups');
        return $query;
    }
    
    /**
     * get site list
     * @return type $query
     */
    function getSites() {
		$this->db->order_by('long_name', 'asc');
        $query = $this->db->get('clients');
        return $query;
    }

    /** 
     * get user admin by user admin id
     * @param type $id
     * @return type string $query
     */
    function GetUsersAdminById($id)
    {
        $this->db->where('id', $id);
        $this->db->order_by('create_date','desc');
        $this->db->limit(1);
        $query = $this->db->get('users');
        return $query;		
    }
	function GetClientById($id)
    {
        $this->db->select("*, CONCAT(lat,',',lng) as ll",false);
        $this->db->where('id', $id);
        $query = $this->db->get('clients');
		return $query;		
    }
	function GetClients()
    {
        $query = $this->db->get("clients");
		return $query;		
    }
    function DeleteClient($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('clients');
    }
	function GetRefType() {
		// $this->db->select('ref_type_client')->from('clients')->group_by('ref_type_client');
		$query = $this->db->get("ref_type_client");
		return $query;
	}
	function distHaversine($coorA,$coorB)
	{
    # jarak kilometer dimensi (mean radius) bumi
			$R = 6371;
		
			$coord_a = explode(",",$coorA);
			$coord_b = explode(",",$coorB);
			$dLat =  ($coord_b[0] - $coord_a[0]) * M_PI / 180;
			$dLong = ($coord_b[1] - $coord_a[1]) * M_PI / 180;
			$a = sin($dLat/2) * sin($dLat/2) + cos((($coord_a[0])* M_PI / 180)) * cos((($coord_b[0])* M_PI / 180)) * sin($dLong/2) * sin($dLong/2);
			$c = 2 * atan2(sqrt($a), sqrt(1-$a));
			$d = $R * $c;
		    $resp = (round($d, 2));
			return $resp;
		
    # hasil akhir dalam satuan kilometer
		
	}
    function GetRefTypeById($id=0) {
	
		// $this->db->select('ref_type_client')->from('clients')->group_by('ref_type_client');
		$query = $this->db->get_where("ref_type_client",array('id_ref_type_client'=>$id));
		$query = $query->row_array();
		return $query['type_client'];
	}
    /**
     * check existing username
     * @param type $username
     * @param type $id
     * @return type boolean (true or false)
     */
    function CheckExistsUsername($username, $id=0)
    {
        if ($id > 0) {
            $this->db->where('id != ', $id);
        }
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($query->num_rows()>0)
        {
            return false;
        }
        else
        {
            return true;
        }	
    }
function PublishClient($id)
    {
		$data = array("publish"=>1);
        $this->db->where('id', $id);
        $this->db->update('clients', $data);	
    }
    
	function UnpublishClient($id)
    {
		$data = array("publish"=>0);
        $this->db->where('id', $id);
        $this->db->update('clients', $data);	
    }
	function InsertClient($data)
    {
        $this->db->insert('clients', $data);
        $id_schedule = $this->db->insert_id();
        return $id_schedule;
    }
	function InsertClientDetail($data)
    {
        $this->db->insert('clients_detail', $data);
        $id_schedule = $this->db->insert_id();
        return $id_schedule;
    }
    /**
     * check existing email
     * @param type $email
     * @param type $id
     * @return type boolean (true or false)
     */
    function CheckExistsEmail($email, $id=0)
    {
        if ($id > 0) {
            $this->db->where('id != ', $id);
        }
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }	
    }

    function checkDuplicateEmail($email, $user_id = 0, $group_id)
    {
        if ($user_id > 0) {
            $this->db->where('nik != ', $user_id);
        }
        $this->db->where('email', $email);
        // $this->db->where('group_id', $group_id);
        $query = $this->db->get('karyawan');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * insert user admin
     * @param type $data
     * @return type string $id last inserted id user admin
     */
    function InsertAdminUser($data)
    {
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();
        return $id;
    }
	function InsertSchedule($data)
    {
        $this->db->insert('schedule', $data);
        $id_schedule = $this->db->insert_id();
        return $id_schedule;
    }

    /**
     * update user admin by id user
     * @param type $id
     * @param type $data 
     */
    function UpdateAdminUser($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }
	function UpdateClient($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('clients', $data);	
    }
	function UpdateClientDetail($id,$data)
    {
        $this->db->where('id_client', $id);
        $this->db->update('clients_detail', $data);	
    }
	
	function ActivateUser($id)
    {
		$data = array('active' => 1);
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }
    
	function DeactivatedUser($id)
    {
		$data = array('active' => 0);
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }
    
    /**
     * delete user admin by id user
     * @param type $id 
     */
    function DeleteAdminUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }
	function DeleteSchedule($id)
    {
        $this->db->where('id_schedule', $id);
        $this->db->delete('schedule'); 
    }

	#==============USER SALES MANAGEMENT
	function GetAllUser($name = null, $email = null, $limit = 0, $per_pg=0)
    {
        if ($name != null) $this->db->where("LCASE(name) LIKE '%".utf8_strtolower($name) . "%'");
        if ($email != null) $this->db->where("LCASE(email) LIKE '%".utf8_strtolower($email) . "%'");
        $this->db->limit($per_pg, $limit);
        $query = $this->db->get('users');
        return $query;
    }
	
	function TotalUser($search1=null,$search2=null)
    {
        $this->db->select('count(*) as total');
        if ($search1 != null) $this->db->where("LCASE(name) LIKE '%".utf8_strtolower($search1) . "%'");
        if ($search2 != null) $this->db->where("LCASE(email) LIKE '%".utf8_strtolower($search2) . "%'");
        $query = $this->db->get('users');
        if ($query->num_rows()>0) {
            $row = $query->row_array();
            return $row['total'];
        } else {
            return '0';
        }
    }

	function GetUserById($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('users');
        return $query;		
    }

	function InsertUser($data)
    {
        $this->db->insert('users', $data);
        $id_user_sales = $this->db->insert_id();
        return $id_user_sales;
    }

	function UpdateUser($id,$data)
    {
        // print_r($data);die();
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

	function DeleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    function getCompanyProfile()
    {
        $this->db->where('id', 1);
        return $this->db->get('company_profile');
    }

    function updateCompanyProfile($data)
    {
        $this->db->where('id', 1);
        $this->db->update('company_profile', $data);
    }
	
	function GetCabang()
	{
		$arrData = get_combobox("SELECT id, nama FROM cabang", "id", "nama");
		
		return $arrData;
	}

    function getInterviewDate()
    {
        $query = $this->db->query("SELECT 
                                        CONCAT(registrations.nama, '-', registrations.nama_perus) AS title, DATE(registrations.jadwal_interview) AS start, registrations.id,
                                        registrations.status, ref_status.name as statusdesc, registrations.no_registration
                                   FROM
                                        registrations LEFT JOIN ref_status
                                        ON registrations.status = ref_status.id
                                   WHERE registrations.jadwal_interview != 'NULL'");
        return $query->result_array();
    }
}


/* End of file admin_model.php */
/* Location: ./application/model/webcontrol/admin_model.php */
