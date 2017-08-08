<?php 
class Stock_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->site_id = $this->session->userdata('ADM_SESS')['site_id'];
		$this->warehouse_id = $this->session->userdata('ADM_SESS')['warehouse_id'];
	}

	function cekProductStock($produkId)
	{
		$ret = false;
		$this->db->where('');
	}

	function stockExists($arrVal = array())
	{
		$ret = false;
		if (count($arrVal) > 0) {
			$this->db->where('entity_id', isset($arrVal['entity_id'])?$arrVal['entity_id']:"");
			$this->db->where('warehouse_id', isset($arrVal['warehouse_id'])?$arrVal['warehouse_id']:"");
			$this->db->where('year', isset($arrVal['year'])?$arrVal['year']:"");
			$this->db->where('month', isset($arrVal['month'])?$arrVal['month']:"");
			$this->db->where('product_id', isset($arrVal['product_id'])?$arrVal['product_id']:"");
			$this->db->where('batch_number', isset($arrVal['batch_number'])?$arrVal['batch_number']:"");
			$this->db->where('expired_date', isset($arrVal['expired_date'])?$arrVal['expired_date']:"");
		}
		$this->db->select('COUNT(*) as jml');
		$sql = $this->db->get('iv_stock_header')->row_array();

		if ($sql['jml'] > 0) {
			$ret = true;
		} else {
			$ret = $this->db->insert('iv_stock_header', $arrVal);
		}

		return $ret;
	}

	function stockDetailExists($arrWhere = array(), $arrVal = array())
	{
		$ret = false;
		if (count($arrWhere) > 0) {
			$this->db->where('entity_id', isset($arrWhere['entity_id'])?$arrWhere['entity_id']:"");
			$this->db->where('warehouse_id', isset($arrWhere['warehouse_id'])?$arrWhere['warehouse_id']:"");
			$this->db->where('year', isset($arrWhere['year'])?$arrWhere['year']:"");
			$this->db->where('month', isset($arrWhere['month'])?$arrWhere['month']:"");
			$this->db->where('product_id', isset($arrWhere['product_id'])?$arrWhere['product_id']:"");
			$this->db->where('batch_number', isset($arrWhere['batch_number'])?$arrWhere['batch_number']:"");
			$this->db->where('expired_date', isset($arrWhere['expired_date'])?$arrWhere['expired_date']:"");
			$this->db->where('document_type', isset($arrWhere['document_type'])?$arrWhere['document_type']:"");
			$this->db->where('document_id', isset($arrWhere['document_id'])?$arrWhere['document_id']:"");
		}
		$this->db->select('COUNT(*) AS jml');
		$sql = $this->db->get('iv_stock_detail')->row_array();

		if ($sql['jml'] > 0) {
			$ret = true;
		} 
	}
}
?>