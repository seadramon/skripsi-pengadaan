<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Penerimaan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'penerimaan';
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
                if ($this->db->insert_batch('detail_penerimaan', $data)) {
                    $result = 1;
                }
            }
        } catch (Exception $e) {
            die($e->error);
        }

        return $result;
    }

    function clearDetail($id)
    {
        $result = null;

        $this->db->where('idpenerimaan', $id);
        if ($this->db->delete('detail_penerimaan')) {
            $result = true;
        }

        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('idpenerimaan', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('idpenerimaan', $id);
        if ($this->db->delete('penerimaan')) {
            $result = true;
        }

        return $result;
    }

    function getTotal($name = null)
    {
        $total = 0;
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));

        $this->db->select('COUNT(idpenerimaan) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER('.$this->table.'.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        // $this->db->where('nik', $this->session->userdata()['ADM_SESS']['nik']);
        $this->db->select("$this->table.*");
        $this->db->from($this->table);
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('idpenerimaan', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function getByIdAll($id)
    {
        $this->db->select('penerimaan.*, detail_penerimaan.*');
        $this->db->from($this->table);
        $this->db->join('detail_penerimaan', $this->table.'.idpenerimaan = detail_penerimaan.idpenerimaan', 'left');

        $this->db->where($this->table.'.idpenerimaan', $id);
        $query = $this->db->get();
        
        return $query;
    }

    function getByIdDokumen($id)
    {
        $this->db->select('penerimaan.idpenerimaan, penerimaan.idpo, supplier.nama as supplier, barang.idbarang, barang.nama as barang, 
            barang.satuan, penerimaan.tanggal, detail_penerimaan.jumlah as jmlTerima,  
            (select jumlah from detail_order where idpo = penerimaan.idpo and idbarang = detail_penerimaan.idbarang) as jmlPesan');
        $this->db->from('penerimaan');
        $this->db->join('detail_penerimaan', 'penerimaan.idpenerimaan = detail_penerimaan.idpenerimaan', 'left');
        $this->db->join('po', 'penerimaan.idpo = po.idpo', 'left');
        $this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');
        $this->db->join('barang', 'detail_penerimaan.idbarang = barang.idbarang', 'left');

        $this->db->where($this->table.'.idpenerimaan', $id);
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