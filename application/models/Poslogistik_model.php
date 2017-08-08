<?php 
/**
* 
*/
class Poslogistik_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	protected $table = "pos_logistik";

	function getTotal($id_insiden, $name = null)
    {
        $total = 0;
        
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        $this->db->where('id_insiden', $id_insiden);
        $this->db->select('COUNT(id_poslogistik) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($id_insiden, $name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(pos_logistik.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select("pos_logistik.*, user.nama as korlog");
        $this->db->where('id_insiden', $id_insiden);
        $this->db->from($this->table);
        $this->db->join('korlog', $this->table.'.id_user = korlog.id_user');
        $this->db->join('user', 'korlog.id_user = user.id_user');

        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_poslogistik', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            // $this->db->set('id_poslogistik', 'UUID()', FALSE);
            $data['id_poslogistik'] = uuid();
            if ($this->db->insert($this->table, $data)) {
                $result = $data['id_poslogistik'];
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_poslogistik', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_poslogistik', $id);
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

        $this->db->where('id_poslogistik', $id);
        $this->db->from($this->table);
        $result = $this->db->count_all_results();

        return $result;
    }

    function showByInsiden($id)
    {
        $this->db->where($this->table.'.id_insiden', $id);
        $this->db->select("pos_logistik.*, user.nama as nama_user");
        $this->db->from($this->table);
        $this->db->join('insiden', $this->table.'.id_insiden = insiden.id_insiden');
        $this->db->join('korlog', $this->table.'.id_user = korlog.id_user');
        $this->db->join('user', 'korlog.id_user = user.id_user', 'inner');

        $query = $this->db->get();

        return $query->result_array();
    }
}
?>  