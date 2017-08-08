<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Pembayaran_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'pembayaran';
	}

	function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
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
            $this->db->where('idpembayaran', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_bank', $id);
        if ($this->db->delete('bank')) {
            $result = true;
        }

        return $result;
    }

    function getTotal($name = null)
    {
        $total = 0;
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));

        $this->db->select('COUNT(idpembayaran) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER('.$this->table.'.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        // $this->db->where('idpembayaran', $this->session->userdata()['ADM_SESS']['idpembayaran']);
        $this->db->select("$this->table.*");
        $this->db->from($this->table);
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('idpembayaran', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function status($id, $status)
    {
    	$result = null;

    	$this->db->where('idbarang', $id);
    	if ($status=='aktif') {
    		$data['status'] = 'non aktif';
    	} else {
    		$data['status'] = 'aktif';
    	}
    	
    	if ($this->db->update($this->table, $data)) {
            $result = 1;
        }

        return $result;
    }

    function maxurut()
    {
        $ret = 0;
        $this->db->select('MAX(urut) as maxUrut');
        $this->db->from($this->table);
        $query = $this->db->get()->row_array();

        if ($query['maxUrut']) $ret = $query['maxUrut'];

        return $ret;
    }
}