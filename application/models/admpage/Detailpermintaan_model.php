<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Detailpermintaan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'detail_permintaan';
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
            $arrSpl = explode("_", $id);
            $idminta = $arrSpl[0];
            $idbarang = $arrSpl[1];

            $this->db->where('idminta', $idminta);
            $this->db->where('idbarang', $idbarang);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function updateByIdMinta($id, $data = array())
    {
        $result = 0;
        $this->db->where('idminta', $id);
        if ($this->db->update($this->table, $data)) {
            $result = 1;
        }

        return $result;
    }

    function delete($id)
    {
        $result = null;

        $arrSpl = explode("_", $id);
        $idminta = $arrSpl[0];
        $idbarang = $arrSpl[1];

        $this->db->where('idminta', $idminta);
        $this->db->where('idbarang', $idbarang);
        if ($this->db->delete($this->table)) {
            $result = true;
        }

        return $result;
    }

    function getTotal($name = null)
    {
        $total = 0;
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));

        $this->db->select('COUNT(idminta) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($header)
    {
        $this->db->where('idminta', $header);
        $this->db->select("$this->table.*, barang.nama as namaBrg, barang.satuan as satuan");
        $this->db->from($this->table);
        $this->db->join('barang', 'barang.idbarang = '.$this->table.'.idbarang', 'left');
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $arrSpl = explode("_", $id);
        $idminta = $arrSpl[0];
        $idbarang = $arrSpl[1];

        $this->db->where('idminta', $idminta);
        $this->db->where('idbarang', $idbarang);
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