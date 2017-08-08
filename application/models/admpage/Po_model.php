<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Po_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'po';
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
                if ($this->db->insert_batch('detail_order', $data)) {
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

        $this->db->where('idpo', $id);
        if ($this->db->delete('detail_order')) {
            $result = true;
        }

        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('idpo', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function updateTotal($idheader)
    {
        $result = 0;
        
        $this->db->where('idpo', $idheader);
        $this->db->select('SUM(jumlah_harga) as total');
        $this->db->from('detail_order');
        $query = $this->db->get()->row_array();
        $result = isset($query['total'])?$query['total']:0;

        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('idpo', $id);
        if ($this->db->delete('po')) {
            $result = true;
        }

        return $result;
    }

    function getTotal($name = null)
    {
        $total = 0;
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));

        $this->db->select('COUNT(idpo) as total');
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
        $this->db->where('idpo', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function getByIdAll($id)
    {
        $this->db->select('po.*, detail_order.*');
        $this->db->from($this->table);
        $this->db->join('detail_order', $this->table.'.idpo = detail_order.idpo', 'left');

        $this->db->where($this->table.'.idpo', $id);
        $query = $this->db->get();
        
        return $query;
    }

    function getByIdDokumen($id)
    {
        $this->db->select('po.*, detail_order.*, supplier.nama as supplier, supplier.fax as supplierfax, barang.nama as barang, 
            barang.satuan');
        $this->db->from($this->table);
        $this->db->join('detail_order', $this->table.'.idpo = detail_order.idpo', 'left');
        $this->db->join('supplier', $this->table.'.idsupplier = supplier.idsupplier', 'left');
        $this->db->join('barang', 'detail_order.idbarang = barang.idbarang', 'left');

        $this->db->where($this->table.'.idpo', $id);
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