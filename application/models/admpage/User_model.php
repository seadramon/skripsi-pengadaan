<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->user_table = 'karyawan';
    }

    function insert($data)
    {
        $ret = false;
        if ($this->db->insert($this->user_table, $data)) {
            $ret = true;
        }
        return $ret;
    }

    function update($id, $data)
    {
        $this->db->where('nik', $id);
        $this->db->update($this->user_table, $data);
    }

    function updateUser($id, $data)
    {
        $this->db->where('nik', $id);
        if ($this->db->update($this->user_table, $data)) {
        	return true;
        } else {
        	return false;
        }
     }

    function delete($id)
    {
        $this->db->where('nik', $id);
        $this->db->delete($this->user_table);
    }

    function get($id = 0)
    {
        $this->db->select($this->user_table.'.*, group.name AS group_name');
        $this->db->join('group', $this->user_table . '.group_id = ' . 'group.id');

        $this->db->where($this->user_table.'.nik', $id);
        $query = $this->db->get($this->user_table);

        return $query;
    }

    function getTotalUser($name = null, $email = null)
    {
        $this->db->select('count(*) as total');

        if($name != null) {
            $this->db->like('LOWER(nama)', strtolower($name));
        }

        if($email != null) {
            $this->db->like('LOWER(email)', strtolower($email));
        }

        $query = $this->db->get($this->user_table);

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['total'];
        } else {
            return '0';
        }
    }

    function getAllUser($name = null, $email = null, $limit=0,$perpage=0)
    {
        $this->db->select($this->user_table.'.*, divisi.nama AS namaDivisi');
        $this->db->join('divisi', $this->user_table . '.iddivisi = ' . 'divisi.iddivisi');
        // $this->db->where($this->user_table.'.jabatan', 'admin');

        if($name != null) {
            $this->db->like('LOWER(nama)', strtolower($name));
        }

        if($email != null) {
            $this->db->like('LOWER(email)', strtolower($email));
        }

        // $this->db->join('group', 'user.group_id = group.id');

        if ($perpage > 0)  $this->db->limit($perpage,$limit);

        $this->db->order_by('nik', 'desc');

        $query = $this->db->get($this->user_table);

        return $query;
    }

    public function getByEmail($email, $group)
    {
        if ($group != null) $this->db->where('group_id', $group);
        $this->db->where('LOWER(email)', strtolower($email));
        $query = $this->db->get($this->user_table);
        return $query;
    }

    public function emailExist($email)
    {
        $this->db->where('email', $email);
        $this->db->where('group_id', 3);
        $this->db->limit(1);
        $query = $this->db->get($this->user_table);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function changeStatus($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->user_table);
        if ($query->num_rows()>0)
        {
            $row = $query->row_array();
            if ($row['activation_status'] == 1) $val = 0;
            else $val = 1;

            $this->db->where('nik',$row['nik']);
            $this->db->update('user', array('activation_status'=>$val));

            if ($val == 1) return 'Active';
            else return 'Not Active';
        }
    }

    function cekEmail($email)
    {
        $jml = 0;
        $this->db->where('email', $email);
        $jml = $this->db->count_all_results($this->user_table);

        return $jml;
    }

    function status($id, $status)
    {
        $result = null;

        $this->db->where('nik', $id);
        if ($status=='aktif') {
            $data['status'] = 'non aktif';
        } else {
            $data['status'] = 'aktif';
        }
        
        if ($this->db->update($this->user_table, $data)) {
            $result = 1;
        }

        return $result;
    }

    function maxurut()
    {
        $ret = 0;
        $this->db->select('MAX(urut) as maxUrut');
        $this->db->from($this->user_table);
        $query = $this->db->get()->row_array();

        if ($query['maxUrut']) $ret = $query['maxUrut'];

        return $ret;
    }
}
