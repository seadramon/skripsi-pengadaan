<?php
/**
* 
*/
class Laporan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function insiden($param = array())
	{
		if (count($param) > 0) {
			if ($param['start'] != "") $this->db->where('insiden.created_at >= ', $param['start']);
			if ($param['end'] != "") $this->db->where('insiden.created_at <= ', $param['end']);

			if ($param['id_fase'] != "") $this->db->where('insiden.id_fase', $param['id_fase']);
			if ($param['id_kategori'] != "") $this->db->where('insiden.id_kategori', $param['id_kategori']);
		}

		$this->db->select('insiden.*, fase.nama as fase, kategori.nama as kategori, organisasi.nama as organisasi');
		$this->db->from('insiden');
		$this->db->join('organisasi', 'insiden.id_organisasi = organisasi.id_organisasi', 'left');
		$this->db->join('fase', 'insiden.id_fase = fase.id_fase', 'left');
		$this->db->join('kategori', 'insiden.id_kategori = kategori.id_kategori', 'left');

		$query = $this->db->get()->result_array();
		return $query;
	}

	function idInsiden($param = array())
	{
		if (count($param) > 0) {
			if ($param['start'] != "") $this->db->where('insiden.created_at >= ', $param['start']);
			if ($param['end'] != "") $this->db->where('insiden.created_at <= ', $param['end']);

			if ($param['id_fase'] != "") $this->db->where('insiden.id_fase', $param['id_fase']);
			if ($param['id_kategori'] != "") $this->db->where('insiden.id_kategori', $param['id_kategori']);
		}

		$this->db->select('insiden.id_insiden');
		$this->db->from('insiden');
		$query = $this->db->get();

		return $query->result_array();
	}

	function kebutuhan($id_insiden = array())
	{
		if (count($id_insiden) > 0) {
			$this->db->where_in('kebutuhan.id_insiden', $id_insiden);
		}

		$this->db->select('kebutuhan.*, tipe.nama as tipe, item.nama as item, satuan.nama as satuan');
		$this->db->from('kebutuhan');
		$this->db->join('tipe', 'kebutuhan.id_tipe = tipe.id_tipe', 'left');
		$this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
		$this->db->join('satuan', 'kebutuhan.id_satuan = satuan.id_satuan', 'left');
		$query = $this->db->get();
		
		return $query->result_array();
	}

	function pos($id_insiden = array())
	{
		if (count($id_insiden) > 0) {
			$this->db->where_in('pos_logistik.id_insiden', $id_insiden);
		}

		$this->db->select('pos_logistik.*, user.nama as korlog');
		$this->db->from('pos_logistik');
		$this->db->join('korlog', 'pos_logistik.id_user = korlog.id_user', 'left');	
		$this->db->join('user', 'korlog.id_user = user.id_user', 'inner');
		$query = $this->db->get();
		
		return $query->result_array();
	}

	function donasi($id_insiden)
	{
		$this->db->where('insiden.id_insiden', $id_insiden);
		$this->db->where('bantuan.is_fund', '1');
		$this->db->select('insiden.nama, bantuan.created, user.nama as donatur, danabantuan.quantity, danabantuan.trf_date, bank.nama as bank, organisasi.nama as organisasi');
		$this->db->from('insiden');
		$this->db->join('organisasi', 'insiden.id_organisasi = organisasi.id_organisasi', 'left');
		$this->db->join('bantuan', 'insiden.id_insiden = bantuan.id_insiden', 'left');
		$this->db->join('danabantuan', 'bantuan.id_bantuan = danabantuan.id_bantuan', 'left');
		$this->db->join('organisasi_bank', 'danabantuan.id_organisasi_bank = organisasi_bank.id_organisasi_bank', 'left');
		$this->db->join('bank', 'organisasi_bank.id_bank = bank.id_bank', 'left');
		$this->db->join('pemberibantuan', 'bantuan.id_user = pemberibantuan.id_user', 'left');	
		$this->db->join('user', 'pemberibantuan.id_user = user.id_user', 'inner');
		$query = $this->db->get();

		return $query->result_array();
	}

	function bantuan($id_insiden)
	{
		$this->db->where('insiden.id_insiden', $id_insiden);
		$this->db->where('bantuan.is_fund', '0');
		$this->db->select('insiden.nama, bantuan.*, user.nama as donatur, detail_bantuan.quantity, satuan.nama as satuan, item.nama as item, organisasi.nama as organisasi');
		$this->db->from('insiden');
		$this->db->join('organisasi', 'insiden.id_organisasi = organisasi.id_organisasi', 'left');
		$this->db->join('bantuan', 'insiden.id_insiden = bantuan.id_insiden', 'left');
		$this->db->join('detail_bantuan', 'bantuan.id_bantuan = detail_bantuan.id_bantuan', 'left');
		$this->db->join('satuan', 'detail_bantuan.id_satuan = satuan.id_satuan', 'left');
		$this->db->join('kebutuhan', 'detail_bantuan.id_kebutuhan = kebutuhan.id_kebutuhan', 'left');
		$this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
		$this->db->join('pemberibantuan', 'bantuan.id_user = pemberibantuan.id_user', 'left');	
		$this->db->join('user', 'pemberibantuan.id_user = user.id_user', 'inner');
		$query = $this->db->get();

		return $query->result_array();
	}

	function penyaluran($id_insiden)
	{
		$this->db->where('insiden.id_insiden', $id_insiden);
        $this->db->select('insiden.id_insiden, insiden.nama as insiden,aktivitas.nama as aktivitas,
    kebutuhan.quantity, detail_bantuan.quantity_received,
    tipe.nama as tipe, item.nama as item, satuan.nama as satuan, kebutuhan.id_item, aktivitas.id_aktivitas,
    (select sum(qty_sent) from aktivitas_detail where id_item = item.id_item and id_aktivitas = aktivitas.id_aktivitas) as qtyKeluar, , organisasi.nama as organisasi');
        $this->db->from('insiden');
        $this->db->join('organisasi', 'insiden.id_organisasi = organisasi.id_organisasi', 'left');
        $this->db->join('kebutuhan', 'kebutuhan.id_insiden = insiden.id_insiden', 'left');
        $this->db->join('detail_bantuan', 'kebutuhan.id_kebutuhan = detail_bantuan.id_kebutuhan', 'left');
        $this->db->join('tipe', 'kebutuhan.id_tipe = tipe.id_tipe', 'left');
        $this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
        $this->db->join('satuan', 'kebutuhan.id_satuan = satuan.id_satuan', 'left');
        $this->db->join('aktivitas', 'insiden.id_insiden = aktivitas.id_insiden', 'left');

        $query = $this->db->get();
        return $query->result_array();
	}

	function aktivitas($id_insiden)
	{
		$this->db->where('id_insiden', $id_insiden);
		$this->db->select('id_aktivitas, nama');
		$this->db->from('aktivitas');

		$query = $this->db->get()->result_array();

		return $query;
	}

	function history($param=array())
	{
		if (count($param) > 0) {
			if ($param['start'] != "") $this->db->where('bantuan.created >= ', $param['start']);
			if ($param['end'] != "") $this->db->where('bantuan.created <= ', $param['end']);

			if ($param['id_tipe'] != "" && $param['id_tipe'] != "fe32f9f4-280c-11e6-9f07-0a0027000000") $this->db->where('bantuan.id_tipe', $param['id_tipe']);
		}

		if ($this->session->userdata('user')['role']=='pemberibantuan') {
			$this->db->where('bantuan.id_user', $this->session->userdata('user')['id_user']);
		}
/*user.nama as user, user.email, user.phone, */
		$this->db->select('user.nama as user, user.email, user.phone, bantuan.created, tipe.nama as tipe, detail_bantuan.quantity_received, satuan.nama as satuan, item.nama as item');
		$this->db->from('bantuan');
		$this->db->join('detail_bantuan', 'bantuan.id_bantuan = detail_bantuan.id_bantuan', 'left');
		$this->db->join('tipe', 'bantuan.id_tipe = tipe.id_tipe', 'left');
		$this->db->join('satuan', 'detail_bantuan.id_satuan = satuan.id_satuan', 'left');
		$this->db->join('kebutuhan', 'detail_bantuan.id_kebutuhan = kebutuhan.id_kebutuhan', 'left');
		$this->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
		$this->db->join('pemberibantuan', 'bantuan.id_user = pemberibantuan.id_user', 'left');	
		$this->db->join('user', 'pemberibantuan.id_user = user.id_user', 'inner');

		$query = $this->db->get()->result_array();
		// print_r($query);die();
		return $query;
	}

	function historyfund($param=array())
	{
		if (count($param) > 0) {
			if ($param['start'] != "") $this->db->where('bantuan.created >= ', $param['start']);
			if ($param['end'] != "") $this->db->where('bantuan.created <= ', $param['end']);

			if ($param['id_tipe'] == "fe32f9f4-280c-11e6-9f07-0a0027000000") $this->db->where('bantuan.id_tipe', $param['id_tipe']);
		}	

		if ($this->session->userdata('user')['role']=='pemberibantuan') {
			$this->db->where('bantuan.id_user', $this->session->userdata('user')['id_user']);
		}

		$this->db->select('user.nama as user, user.email, user.phone, user.alamat, bantuan.created, danabantuan.quantity, tipe.nama as tipe');
		$this->db->from('bantuan');
		$this->db->join('danabantuan', 'bantuan.id_bantuan = danabantuan.id_bantuan', 'left');
		$this->db->join('tipe', 'bantuan.id_tipe = tipe.id_tipe', 'left');
		$this->db->join('pemberibantuan', 'bantuan.id_user = pemberibantuan.id_user', 'left');	
		$this->db->join('user', 'pemberibantuan.id_user = user.id_user', 'inner');

		$query = $this->db->get()->result_array();

		return $query;
	}
}