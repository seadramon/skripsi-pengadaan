<?php 
/**
* 
*/
class Kebutuhan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	protected $table = "kebutuhan";

	function getTotal($id_insiden, $name = null)
    {
        $total = 0;
        
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        $this->db->where('id_insiden', $id_insiden);
        $this->db->select('COUNT(id_kebutuhan) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($id_insiden, $name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(kebutuhan.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select("kebutuhan.*, tipe.nama as tipe, item.nama as item");
        $this->db->where('id_insiden', $id_insiden);
        $this->db->from($this->table);
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');
        $this->db->join('item', $this->table.'.id_item = item.id_item');

        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_kebutuhan', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function getTipeKebutuhan($id)
    {
        $this->db->where('id_insiden', $id);
        $this->db->select('kebutuhan.id_tipe, tipe.nama as tipe');
        $this->db->from($this->table);
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');
        $this->db->group_by("kebutuhan.id_tipe");

        $query = $this->db->get();
        
        return $query->result_array();
    }

    function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            // $this->db->set('id_kebutuhan', 'UUID()', FALSE);
            $data['id_kebutuhan'] = uuid();
            if ($this->db->insert($this->table, $data)) {
                // get total kebutuhan
                $this->db->where('id_insiden', $data['id_insiden']);
                $this->db->select_sum('unit_price');
                $totalKebutuhan = $this->db->get('kebutuhan')->row('unit_price');
                // update estimasi dana
                $this->db->where('id_insiden', $data['id_insiden']);
                $this->db->set('dana_estimasi', $totalKebutuhan);
                $this->db->update('insiden');

                $result = 1;
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_kebutuhan', $id);
            if ($this->db->update($this->table, $data)) {
                // get total kebutuhan
                $this->db->where('id_insiden', $data['id_insiden']);
                $this->db->select_sum('unit_price');
                $totalKebutuhan = $this->db->get('kebutuhan')->row('unit_price');
                // update estimasi dana
                $this->db->where('id_insiden', $data['id_insiden']);
                $this->db->set('dana_estimasi', $totalKebutuhan);
                $this->db->update('insiden');
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_kebutuhan', $id);
        if ($this->db->delete($this->table)) {
            /*$this->db->where('id_insiden', $id);
            $this->db->delete('kebutuhan');*/
            
            $result = true;
        }

        return $result;
    }

    function jmlKebutuhan($id)
    {
        $result = 0;

        $this->db->where('id_insiden', $id);
        $this->db->from('kebutuhan');
        $result = $this->db->count_all_results();

        return $result;
    }

    function statusInsiden($id_insiden, $status)
    {   
        $this->db->set('status', $status);
        $this->db->where($id_insiden);
        $this->db->update('insiden');
    }

    function showByInsiden($id_insiden)
    {
        $this->db->where($this->table.'.id_insiden', $id_insiden);
        $this->db->select("kebutuhan.*, tipe.nama as tipe, item.nama as item, satuan.nama as satuan");
        $this->db->from($this->table);
        $this->db->join('insiden', $this->table.'.id_insiden = insiden.id_insiden');
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');
        $this->db->join('item', $this->table.'.id_item = item.id_item');
        $this->db->join('satuan', $this->table.'.id_satuan = satuan.id_satuan');

        $query = $this->db->get();

        return $query->result_array();
    }

    

    /*----------------OTHER---------------------------------*/
    function jmlPerTipe($id_insiden)
    {
        $this->db->where('kebutuhan.id_insiden', $id_insiden);
        $this->db->select('sum(kebutuhan.quantity) as qtyKebutuhan, tipe.nama as tipe');
        $this->db->from($this->table);
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');

        $query = $this->db->get();

        return $query->result_array();
    }

    function getByInsiden($id_tipe, $id_insiden)
    {
        $this->db->where('kebutuhan.id_insiden', $id_insiden);
        $this->db->where('kebutuhan.id_tipe', $id_tipe);
        $this->db->select('kebutuhan.*, item.nama as item, satuan.nama as satuan');
        $this->db->from($this->table);
        $this->db->join('item', $this->table.'.id_item = item.id_item');
        $this->db->join('satuan', $this->table.'.id_satuan = satuan.id_satuan');

        $query = $this->db->get();

        return $query->result_array();
    }

    function getPersentase($id_insiden, $id_tipe)
    {
        $this->db->where('kebutuhan.id_insiden', $id_insiden);
        $this->db->where('kebutuhan.id_tipe', $id_tipe);
        $this->db->select("tipe.nama as tipe, item.nama as item, satuan.nama as satuan,
    kebutuhan.quantity as qtyKebutuhan, (select sum(detail_bantuan.quantity_received) from detail_bantuan where id_kebutuhan = kebutuhan.id_kebutuhan) as qtyBantuan");
        $this->db->from($this->table);
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');
        $this->db->join('item', $this->table.'.id_item = item.id_item');
        $this->db->join('satuan', $this->table.'.id_satuan = satuan.id_satuan');
        
        // $this->db->isdebug(TRUE);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>  