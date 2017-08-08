<?php 
/**
* 
*/
class Organisasi_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	protected $table = 'organisasi';
    protected $tablebank = 'organisasi_bank';

	function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
        	$this->db->set('id_organisasi', 'UUID()', FALSE);
            if ($this->db->insert($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_kategori', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function assignKorlog($id_user, $id_poslogistik)
    {
        $result = false;

        $this->db->set('id_poslogistik', $id_poslogistik);
        $this->db->where('id_user', $id_user);
        $result = $this->db->update('korlog');
        
        return $result;
    }

    function getTotalBank($name = null)
    {
        $total = 0;
        
        if ($this->session->userdata('org')) {
            $this->db->where('organisasi_bank.id_organisasi', $this->session->userdata('org')['id_organisasi']);
        }
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        $this->db->select('COUNT(id_organisasi_bank) as total');
        $query = $this->db->get($this->tablebank)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAllBank($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(organisasi_bank.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        if ($this->session->userdata('org')) {
            $this->db->where('organisasi_bank.id_organisasi', $this->session->userdata('org')['id_organisasi']);
        }

        $this->db->select("organisasi_bank.*, organisasi.nama as organisasi, bank.nama as bank");
        $this->db->from($this->tablebank);
        $this->db->join($this->table, $this->tablebank.'.id_organisasi = organisasi.id_organisasi');
        $this->db->join('bank', $this->tablebank.'.id_bank = bank.id_bank');

        $query = $this->db->get();

        return $query;
    }

    function getTotalUser($name = null)
    {
        $total = 0;

        $sql = sprintf("select count(id_user) as total from 
                        (
                            (select leader.id_user, leader.id_organisasi, user.nama, user.role
                                from leader
                                inner join user on leader.id_user = user.id_user)
                            union
                            (select korlap.id_user, korlap.id_organisasi, user.nama, user.role
                                from korlap
                                inner join user on korlap.id_user = user.id_user)
                            union
                            (select korlog.id_user, korlog.id_organisasi, user.nama, user.role
                                from korlog
                                inner join user on korlog.id_user = user.id_user)
                            union
                            (select admin_org.id_user, admin_org.id_organisasi, user.nama, user.role
                                from admin_org
                                inner join user on admin_org.id_user = user.id_user)
                        ) as t
                        where id_organisasi = '%s'", $this->session->userdata('org')['id_organisasi']);

        $result = $this->db->query($sql)->row_array();
        $total = isset($result['total'])?$result['total']:0;

        return $total;
    }

    function getAllUser($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(organisasi_bank.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $sql = sprintf("select * from 
                        (
                            (select leader.id_user, leader.id_organisasi, user.nama, user.role, user.status,
                                user.email
                                from leader
                                inner join user on leader.id_user = user.id_user)
                            union
                            (select korlap.id_user, korlap.id_organisasi, user.nama, user.role, user.status,
                                user.email
                                from korlap
                                inner join user on korlap.id_user = user.id_user)
                            union
                            (select korlog.id_user, korlog.id_organisasi, user.nama, user.role, user.status,
                                user.email
                                from korlog
                                inner join user on korlog.id_user = user.id_user)
                            union
                            (select admin_org.id_user, admin_org.id_organisasi, user.nama, user.role, user.status,
                                user.email
                                from admin_org
                                inner join user on admin_org.id_user = user.id_user)
                        ) as t
                        where id_organisasi = '%s' 
                        limit %d offset %d", $this->session->userdata('org')['id_organisasi'], $per_pg, $limit);

        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    function getByIdBank($id)
    {
        $this->db->where('id_organisasi_bank', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->tablebank);
        
        return $query;
    }

    function getUserById($id)
    {
        $this->db->where('id_user', $id);
        $this->db->limit(1);
        $query = $this->db->get('user');
        
        return $query;
    }

    function insertBank($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            $data['id_organisasi_bank'] = uuid();
            if ($this->db->insert($this->tablebank, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function updateBank($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_organisasi_bank', $id);
            if ($this->db->update($this->tablebank, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function statusBank($id, $status)
    {
        $result = null;

        $this->db->where('id_organisasi_bank', $id);
        if ($status=='publish') {
            $data['status'] = 'unpublish';
        } else {
            $data['status'] = 'publish';
        }
        
        if ($this->db->update($this->tablebank, $data)) {
            $result = 1;
        }

        return $result;
    }

    function organisasi_bank($id_organisasi) 
    {
        $this->db->where('id_organisasi', $id_organisasi);
        $this->db->select("organisasi_bank.*, bank.nama as bank");
        $this->db->from($this->tablebank);
        $this->db->join('bank', $this->tablebank.'.id_bank = bank.id_bank');

        $query = $this->db->get();

        return $query->result_array();
    }

    function statusUser($id, $updateStat)
    {
        $this->db->where('id_user', $id);
        $this->db->set('status', $updateStat);

        return $this->db->update('user');
    }

    function insertUser($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            $data['id_user'] = uuid();
            $data['password'] = md5('bantuin');
            $data['status'] = '1';
            if ($this->db->insert('user', $data)) {
                $detail = array('id_user' => $data['id_user'],
                    'id_organisasi' => $this->session->userdata('org')['id_organisasi']);
                $this->db->insert(strtolower($data['role']), $detail);
                $result = 1;
            }
        }
        return $result;
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

    function deleteUser($id)
    {
        $result = null;

        $role = $this->db->get_where('user', array('id_user', $id))->row('role');

        $this->db->where('id_user', $id);
        if ($this->db->delete('user')) {
            $this->db->where('id_user', $id);
            $this->db->delete('role');
            
            $result = true;
        }

        return $result;
    }
}
?>