<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Satuan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

    protected $table = "satuan";

	function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
        	$this->db->set('id_satuan', 'UUID()', FALSE);
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
            $this->db->where('id_satuan', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_satuan', $id);
        if ($this->db->delete($this->table)) {
            $result = true;
        }

        return $result;
    }

    function getTotal($name = null)
    {
        $total = 0;
        
        if ($name != null) $this->db->like(sprintf("LOWER(%s.nama)", $this->table), strtolower($name));
        $this->db->select('COUNT(id_satuan) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like(sprintf("LOWER(%s.nama)", $this->table), strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select($this->table.'.*, tipe.nama as tipe');
        $this->db->from($this->table);
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');

        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_satuan', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function status($id, $status)
    {
    	$result = null;

    	$this->db->where('id_satuan', $id);
    	if ($status=='publish') {
    		$data['status'] = 'unpublish';
    	} else {
    		$data['status'] = 'publish';
    	}
    	
    	if ($this->db->update($this->table, $data)) {
            $result = 1;
        }

        return $result;
    }
}



?>