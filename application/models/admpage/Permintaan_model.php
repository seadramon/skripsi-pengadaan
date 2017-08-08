<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Permintaan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'permintaan';
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

    function insertDetail($data)
    {
        $result = 0;;
        try {
            if (is_array($data) && count($data) > 0) {
                if ($this->db->insert_batch('detail_'.$this->table, $data)) {
                    $result = 1;
                }
            }
        } catch (Exception $e) {
            die($e->error);
        }

        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('idminta', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function clearDetail($id)
    {
        $result = null;

        $this->db->where('idminta', $id);
        if ($this->db->delete('detail_permintaan')) {
            $result = true;
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

        if ($this->session->userdata()['ADM_SESS']['iddivisi']=='D03') {
            $this->db->where('nik', $this->session->userdata()['ADM_SESS']['nik']);
        }
        $this->db->select('COUNT(idminta) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER('.$this->table.'.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        if ($this->session->userdata()['ADM_SESS']['iddivisi']=='D03') {
            $this->db->where('nik', $this->session->userdata()['ADM_SESS']['nik']);
        }
        $this->db->select("$this->table.*");
        $this->db->from($this->table);
        $query = $this->db->get();

        return $query;
    }

    function getTotalAktif($name = null)
    {
        $total = 0;
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));

        $this->db->select('COUNT(idminta) as total');
        $this->db->where('status', 'disetujui');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAllAktif()
    {
        $this->db->where('status', 'disetujui');
        $this->db->select("$this->table.*");
        $this->db->from($this->table);
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('idminta', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function getByIdAll($id)
    {
        $this->db->select('permintaan.*, detail_permintaan.*');
        $this->db->from($this->table);
        $this->db->join('detail_permintaan', $this->table.'.idminta = detail_permintaan.idminta', 'left');

        $this->db->where($this->table.'.idminta', $id);
        $query = $this->db->get();
        
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