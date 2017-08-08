<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Bank_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
        	// $this->db->set('id', 'UUID()', FALSE);
            if ($this->db->insert('bank', $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_bank', $id);
            if ($this->db->update('bank', $data)) {
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
        $this->db->select('COUNT(id_bank) as total');
        $query = $this->db->get('bank')->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(bank.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select("bank.*");
        $this->db->from('bank');
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_bank', $id);
        $this->db->limit(1);
        $query = $this->db->get('bank');
        
        return $query;
    }

    function status($id, $status)
    {
    	$result = null;

    	$this->db->where('id_bank', $id);
    	if ($status=='publish') {
    		$data['status'] = 'unpublish';
    	} else {
    		$data['status'] = 'publish';
    	}
    	
    	if ($this->db->update('bank', $data)) {
            $result = 1;
        }

        return $result;
    }
}



?>