<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Detailpo_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'detail_order';
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
            $idpo = $arrSpl[0];
            $idbarang = $arrSpl[1];

            $this->db->where('idpo', $idpo);
            $this->db->where('idbarang', $idbarang);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $arrSpl = explode("_", $id);
        $idpo = $arrSpl[0];
        $idbarang = $arrSpl[1];

        $this->db->where('idpo', $idpo);
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

        $this->db->select('COUNT(iddetail_order) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($header = "")
    {
        if ($header != "") $this->db->where('idpo', $header);

        $this->db->select("$this->table.*, barang.nama as namaBrg, barang.satuan as satuan");
        $this->db->from($this->table);
        $this->db->join('barang', 'barang.idbarang = '.$this->table.'.idbarang', 'left');
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $arrSpl = explode("_", $id);
        $idpo = $arrSpl[0];
        $idbarang = $arrSpl[1];

        $this->db->where('idpo', $idpo);
        $this->db->where('idbarang', $idbarang);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }
}