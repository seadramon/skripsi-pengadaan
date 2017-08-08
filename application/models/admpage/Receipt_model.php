<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Receipt_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->site_id = $this->session->userdata('ADM_SESS')['site_id'];
        $this->warehouse_id = $this->session->userdata('ADM_SESS')['warehouse_id'];
	}

	function getTotal($searchBy = null, $searchVal = null)
    {
        $ret = 0;
        
        if ($searchBy != null && $searchVal != null) {
            $this->db->like("LOWER($searchBy)", strtolower($searchVal));
        }
        $this->db->select('COUNT(document_id) as total');
        $query = $this->db->get('iv_receipt_header')->row_array();
        $ret = isset($query['total'])?$query['total']:0;

        return $ret;
    }

    function getHeaderById($docId)
    {
    	$this->db->select('site_id, document_id, document_type, document_origin_id, document_reference, gross_amount, nett_amount');
    	$this->db->where('document_id', $docId);
    	$query = $this->db->get('iv_receipt_header');

    	return $query->row_array();
    }

    function getDetailById($docId)
    {
    	$this->db->select("iv_receipt_detail.document_id, iv_receipt_detail.product_id, GROUP_CONCAT(iv_receipt_detail.unit_id, ':', iv_receipt_detail.qty) as arrQty, iv_receipt_detail.batch_number, iv_receipt_detail.expired_date, iv_receipt_detail.price, iv_receipt_detail.gross_amount, iv_receipt_detail.nett_amount, ms_product.name", FALSE);
    	$this->db->where('iv_receipt_detail.document_id', $docId);
        $this->db->from('iv_receipt_detail');
        $this->db->join('ms_product', 'iv_receipt_detail.product_id = ms_product.product_id');
    	$this->db->group_by('iv_receipt_detail.product_id');
    	$query = $this->db->get();

    	return $query->result_array();
    }

    function getAll($searchBy = null, $searchVal = null,$perPage = 0, $offset = 0)
    {
        $sdata = array();
        $where = "";

        if ($searchBy != null && $searchVal != null) {
            $where = "WHERE LOWER($searchBy) LIKE '%".$this->db->escape_like_str(strtolower($searchVal))."%'";
        }
        $query = sprintf("SELECT document_id, date, document_origin_id, document_type, document_reference
                          FROM iv_receipt_header %s
                          ORDER BY date desc LIMIT %d, %d", 
                          $where, $offset, $perPage);
        $res = $this->db->query($query);

        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $row) {
                $sdata[] = array('document_id' => $row['document_id'], 'date' => $row['date'], 'document_origin_id' => $row['document_origin_id'], 'document_type' => $row['document_type'], 'document_reference' => $row['document_reference']);
            }
        }

        return $sdata;
    }

	public function insertHeader($data = array())
	{
		$ret = false;
		if (count($data) > 0) {
			$ret = $this->db->insert('iv_receipt_header', $data);
		}
		return $ret;
	}

    public function updateHeader($id, $data = array())
    {
        $ret = false;
        if (count($data) > 0) {
            $this->db->where('document_id', $id);
            $ret = $this->db->update('iv_receipt_header', $data);
        }
        return $ret;
    }

	public function insertDetail($data = array())
	{
		$ret = false;
		$noDebug = $this->load->database('noDebug', TRUE);
		if (count($data) > 0) {
			$ret = $noDebug->insert_batch('iv_receipt_detail', $data);
		}
		return $ret;
	}

	public function delete($docId)
	{
		$ret = false;
		$tables = array('iv_receipt_header', 'iv_receipt_detail');

		$this->db->where('document_id', $docId);
		if ($this->db->delete('iv_receipt_header')) {
			$this->db->where('document_id', $docId);
			$ret = $this->db->delete('iv_receipt_detail');
		}
		return $ret;
	}

    public function deleteDetailByDocId($docId) 
    {
        $this->db->where('document_id', $docId);
        return $this->db->delete('iv_receipt_detail');
    }
}

?>