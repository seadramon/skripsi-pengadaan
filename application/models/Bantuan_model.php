<?php 
/**
* 
*/
class Bantuan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	protected $table = "bantuan";
	protected $child_table = "detail_bantuan";
	protected $child_table2 = "danabantuan";

	function insert($data, $detail)
    {
        $result = 0;
        $arrDetail = array();
        if (is_array($data) && count($data) > 0) {
        	$data['id_bantuan'] = uuid();
            if ($this->db->insert($this->table, $data)) {
            	foreach ($detail as $key => $value) {
            		$a = $this->db->get_where('kebutuhan', array('id_kebutuhan' => $key))->row('id_satuan');
		        	if ($value!="") {
		        		$arrDetail[] = array('id_detail_bantuan' => uuid(),
		        			'id_bantuan' => $data['id_bantuan'],
		        			'id_kebutuhan' => $key,
                            'status' => 'submitted',
		        			'id_satuan' => $this->db->get_where('kebutuhan', array('id_kebutuhan' => $key))->row('id_satuan'),
		        			'quantity' => $value);
		        	}
		        }
		        if (count($arrDetail) > 0) {
					$this->db->insert_batch($this->child_table, $arrDetail);
					$result = 1;
		        }
            }
        }
        return $result;
    }

    function insertDana($data, $detail)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            if ($this->db->insert($this->table, $data)) {
                $this->db->insert($this->child_table2, $detail);
                $result = 1;
            }
        }
        return $result;
    }

	/*-------------OTHER-----------------*/
	function jmlPerTipe($id_insiden)
    {
        $this->db->where($this->table.'.id_insiden', $id_insiden);
        $this->db->select('sum(detail_bantuan.quantity_received) as qtyBantuan, tipe.nama as tipe');
        $this->db->from($this->child_table);
        $this->db->join($this->table, $this->child_table.'.id_bantuan = bantuan.id_bantuan');
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe');

        $query = $this->db->get();

        return $query->result_array();
    }

    function jmlPerDana($id_insiden)
    {
        $this->db->where($this->table.'.id_insiden', $id_insiden);
        $this->db->select('sum(danabantuan.quantity) as qtyDana');
        $this->db->from($this->child_table2);
        $this->db->join($this->table, $this->child_table2.'.id_bantuan = bantuan.id_bantuan');

        $query = $this->db->get();

        return $query->row_array();
    }

    function tipe()
    {
        $this->db->limit(4);
        $query = $this->db->get('tipe');
        
        return $query->result_array();
    }

    function getAllBantuan($id_insiden, $id_tipe, $per_pg = null, $limit = null)
    {
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->where($this->table.'.id_insiden', $id_insiden);
        $this->db->where($this->table.'.id_tipe', $id_tipe);

        $this->db->select("user.nama as pemberibantuan, pos_logistik.nama as pos, satuan.nama as satuan, item.nama as item,
    detail_bantuan.id_detail_bantuan, detail_bantuan.quantity, detail_bantuan.quantity_received, detail_bantuan.status, 
    bantuan.created, bantuan.id_insiden, bantuan.id_tipe, bantuan.id_bantuan");
        $this->db->from($this->table);
        $this->db->join($this->child_table, $this->table.'.id_bantuan = detail_bantuan.id_bantuan', 'right');
        $this->db->join('pos_logistik', $this->table.'.id_poslogistik = pos_logistik.id_poslogistik', 'left' );
        $this->db->join('satuan', $this->child_table.'.id_satuan = satuan.id_satuan', 'left' );
        $this->db->join('kebutuhan', $this->child_table.'.id_kebutuhan = kebutuhan.id_kebutuhan', 'left' );
        $this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left' );
        $this->db->join('tipe', $this->table.'.id_tipe = tipe.id_tipe', 'left' );
        $this->db->join('user', $this->table.'.id_user = user.id_user', 'left' );

        $query = $this->db->get();
        return $query->result_array();
    }

    function getTotalBantuan($id_insiden, $id_tipe)
    {
        $total = 0;

        $this->db->where($this->table.'.id_insiden', $id_insiden);
        $this->db->where($this->table.'.id_tipe', $id_tipe);
        $this->db->select('COUNT(detail_bantuan.id_detail_bantuan) as total');
        $this->db->from($this->table);
        $this->db->join($this->child_table, $this->table.'.id_bantuan = detail_bantuan.id_bantuan', 'right');

        $query = $this->db->get()->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getFormUpdate($id_tipe, $id_insiden, $id_bantuan)
    {
        $this->db->where($this->table.'.id_bantuan', $id_bantuan);
        $this->db->where($this->table.'.id_insiden', $id_insiden);
        $this->db->where($this->table.'.id_tipe', $id_tipe);
        $this->db->select('detail_bantuan.id_detail_bantuan, detail_bantuan.quantity, detail_bantuan.quantity_received, 
    satuan.nama as satuan, item.nama as item');
        $this->db->from($this->table);
        $this->db->join($this->child_table, $this->table.'.id_bantuan = detail_bantuan.id_bantuan', 'right');
        $this->db->join('satuan', $this->child_table.'.id_satuan = satuan.id_satuan', 'left');
        $this->db->join('kebutuhan', $this->child_table.'.id_kebutuhan = kebutuhan.id_kebutuhan', 'left');
        $this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');

        $query = $this->db->get();
        return $query->result_array();
    }

    function updateBantuan($detail)
    {
        $result = 0;
        if (count($detail) > 0 && is_array($detail)) {
            foreach ($detail as $value) {
                $data = array('quantity_received' => $value['quantity_received']+$value['qtyTerima'],
                    'status' => 'received');

                $this->db->where('id_detail_bantuan', $value['id_detail_bantuan']);
                if ($this->db->update($this->child_table, $data)) {
                    $result = 1;
                }
            }
        }

        return $result;
    }

    function getBantuanTerkumpul($id_insiden)
    {
        $this->db->where('bantuan.id_insiden', $id_insiden);
        $this->db->select('sum((detail_bantuan.quantity_received * kebutuhan.harga_satuan)) as nilaiBantuanDrop,
    sum(danabantuan.quantity) as nilaiBantuanDana');
        $this->db->from($this->table);
        $this->db->join($this->child_table, $this->table.'.id_bantuan = detail_bantuan.id_bantuan', 'left');
        $this->db->join($this->child_table2, $this->table.'.id_bantuan = danabantuan.id_bantuan', 'left');
        $this->db->join('kebutuhan', $this->child_table.'.id_kebutuhan = kebutuhan.id_kebutuhan', 'left');
        $this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
        $this->db->join('tipe', 'kebutuhan.id_tipe = tipe.id_tipe', 'left');

        $query = $this->db->get();

        return $query->row_array();
    }

    function getBantuanTerkumpulDrop($id_insiden)
    {
        $this->db->select(' bantuan.id_insiden,bantuan.id_bantuan,kebutuhan.id_kebutuhan, tipe.nama as tipe, item.nama as item,
    kebutuhan.quantity as qtyKebutuhan, kebutuhan.harga_satuan, kebutuhan.unit_price, 
    detail_bantuan.quantity_received as qtyBantuan, satuan.nama as satuan');
        $this->db->from($this->table);
        $this->db->where('bantuan.is_fund', '0');
        $this->db->where('bantuan.id_insiden', $id_insiden);
        $this->db->join($this->child_table, $this->table.'.id_bantuan = detail_bantuan.id_bantuan', 'left');
        $this->db->join('kebutuhan', $this->child_table.'.id_kebutuhan = kebutuhan.id_kebutuhan', 'left');
        $this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
        $this->db->join('tipe', 'kebutuhan.id_tipe = tipe.id_tipe', 'left');
        $this->db->join('satuan', 'kebutuhan.id_satuan = satuan.id_satuan', 'left');
// $this->db->isdebug(true);
        $query = $this->db->get();

        return $query->result_array();
    }
}
?>