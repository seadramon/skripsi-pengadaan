<?php 
/**
* 
*/
class Insiden_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	protected $table = "insiden";

	function getTotal($name = null)
    {
        $total = 0;
        
        if ($this->session->userdata('org')) {
            $this->db->where('id_organisasi', $this->session->userdata('org')['id_organisasi']);
        }
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        $this->db->select('COUNT(id_insiden) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(insiden.nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        if ($this->session->userdata('org')) {
            $this->db->where('insiden.id_organisasi', $this->session->userdata('org')['id_organisasi']);
        }

        $this->db->order_by('created_at', 'DESC');
        $this->db->select("insiden.*, kategori.nama as kategori, fase.nama as fase, organisasi.nama as organisasi");
        $this->db->from($this->table);
        $this->db->join('organisasi', $this->table.'.id_organisasi = organisasi.id_organisasi');
        $this->db->join('kategori', $this->table.'.id_kategori = kategori.id_kategori');
        $this->db->join('fase', $this->table.'.id_fase = fase.id_fase');

        // $this->db->isdebug(true);
        $query = $this->db->get();

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_insiden', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function showById($id)
    {
        $this->db->where($this->table.'.id_insiden', $id);
        $this->db->select("insiden.*, organisasi.nama as organisasi, kategori.nama as kategori, fase.nama as fase");
        $this->db->from($this->table);
        $this->db->join('organisasi', $this->table.'.id_organisasi = organisasi.id_organisasi');
        $this->db->join('kategori', $this->table.'.id_kategori = kategori.id_kategori');
        $this->db->join('fase', $this->table.'.id_fase = fase.id_fase');

        $query = $this->db->get();

        return $query;
    }

    function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            $this->db->set('id_insiden', 'UUID()', FALSE);
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
            $this->db->where('id_insiden', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_insiden', $id);
        if ($this->db->delete($this->table)) {
            /*$this->db->where('id_insiden', $id);
            $this->db->delete('kebutuhan');*/
            
            $result = true;
        }

        return $result;
    }

    function confirmInsiden($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id_insiden', $id);

        $result = $this->db->update($this->table);

        return $result;
    }


    // -----------------OTHER-------------------------------
}
?>  