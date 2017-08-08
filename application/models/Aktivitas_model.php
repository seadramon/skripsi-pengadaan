<?php 
/**
* 
*/
class Aktivitas_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	protected $table = "aktivitas";
    protected $tabledetail = "aktivitas_detail";

	function getTotal($id_insiden, $name = null)
    {
        $total = 0;
        
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        $this->db->where('id_insiden', $id_insiden);
        $this->db->select('COUNT(id_aktivitas) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($id_insiden, $name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(aktivitas.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select("aktivitas.*, insiden.nama as insiden");
        $this->db->where('aktivitas.id_insiden', $id_insiden);
        $this->db->from($this->table);
        $this->db->join('insiden', $this->table.'.id_insiden = insiden.id_insiden');

        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_aktivitas', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            $data['id_aktivitas'] = uuid();
            if ($this->db->insert($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function insertDetail($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            // $data['id_aktivitasdetail'] = uuid();
            if ($this->db->insert_batch($this->tabledetail, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_aktivitas', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_aktivitas', $id);
        if ($this->db->delete($this->table)) {
            $this->db->where('id_aktivitas', $id);
            $this->db->delete($this->tabledetail);
            
            $result = true;
        }

        return $result;
    }

    function getFormDetail($id_insiden, $id_aktivitas)
    {
        $this->db->where('insiden.id_insiden', $id_insiden);
        $this->db->where('aktivitas.id_aktivitas', $id_aktivitas);
        $this->db->select('insiden.id_insiden, 
    kebutuhan.quantity, detail_bantuan.quantity_received,
    tipe.nama as tipe, item.nama as item, satuan.nama as satuan, kebutuhan.id_item,
    (select sum(qty_sent) from aktivitas_detail where id_item = item.id_item and id_aktivitas = aktivitas.id_aktivitas) as qtyKeluar');
        $this->db->from('insiden');
        $this->db->join('kebutuhan', 'kebutuhan.id_insiden = insiden.id_insiden', 'left');
        $this->db->join('detail_bantuan', 'kebutuhan.id_kebutuhan = detail_bantuan.id_kebutuhan', 'left');
        $this->db->join('tipe', 'kebutuhan.id_tipe = tipe.id_tipe', 'left');
        $this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
        $this->db->join('satuan', 'kebutuhan.id_satuan = satuan.id_satuan', 'left');
        $this->db->join('aktivitas', 'insiden.id_insiden = aktivitas.id_insiden', 'left');

        $query = $this->db->get();
        return $query->result_array();
    }

    function clearDetail($id_aktivitas)
    {
        $this->db->where('id_aktivitas', $id_aktivitas);
        $this->db->delete($this->tabledetail);
    }
}
?>  