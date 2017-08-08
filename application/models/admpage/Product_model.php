<?php 
class Product_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function getTotal($searchBy = null, $searchVal = null)
    {
        $ret = 0;
        
        if ($searchBy != null && $searchVal != null) {
            $this->db->like("LOWER($searchBy)", strtolower($searchVal));
        }
        $this->db->select('COUNT(product_id) as total');
        $query = $this->db->get('ms_product')->row_array();
        $ret = isset($query['total'])?$query['total']:0;

        return $ret;
    }

    function getAll($searchBy = null, $searchVal = null,$perPage = 0, $offset = 0)
    {
        $sdata = array();
        $where = "";

        if ($searchBy != null && $searchVal != null) {
            $where = "WHERE LOWER($searchBy) LIKE '%".$this->db->escape_like_str(strtolower($searchVal))."%'";
        }
        $query = sprintf("SELECT product_id, name, current_stock, current_price 
                          FROM ms_product %s
                          ORDER BY product_id desc LIMIT %d, %d", 
                          $where, $offset, $perPage);
        $res = $this->db->query($query);

        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $row) {
                $sdata[] = array('product_id' => $row['product_id'], 'name' => $row['name'], 'stock' => $row['current_stock'], 'price' => $row['current_price']);
            }
        }

        return $sdata;
    }

    function cekFlag($productId, $flag = "batch_flag")
    {
    	$ret = "0";
    	$this->db->where('product_id', $productId);
    	$this->db->select($flag);
    	$query = $this->db->get('ms_product')->row_array();

    	$ret = isset($query[$flag])?$query[$flag]:"0";
    	return $ret;
    }

    function getById($productId)
    {
        $this->db->where('product_id', $productId);
        $query = $this->db->get('ms_product');
        
        return $query->row_array();
    }

    function maxDocId()
    {
        $this->db->select('MAX(document_id) as maks, date');
        $this->db->like('document_id', 'RG'.date('Ym'), 'after');
        $sql = $this->db->get('iv_receipt_header')->row_array();

        return $sql;
    }

    function getUnitQty($productId)
    {
        $this->db->where('product_id', $productId);
        $query = $this->db->get('ms_product_uom');

        return $query->result_array();
    }

    function getHighMeasure($productId)
    {
        $ret = "";
        $this->db->select('measure, unit_id');
        $where = sprintf("product_id = '%s'
                        AND unit_id = 
                        (SELECT purchase_unit_id
                        FROM ms_product
                        WHERE product_id = '%s')", $productId, $productId);
        $this->db->where($where);
        /*$this->db->isdebug(TRUE);*/
        $query = $this->db->get('ms_product_uom');
        $ret = $query->row_array();

        return $ret;
    }

    function getLowMeasure($productId)
    {
        $ret = "";
        $this->db->select('measure, unit_id');
        $this->db->where('product_id', $productId);
        $this->db->order_by('measure');
        /*$this->db->isdebug(TRUE);*/
        $query = $this->db->get('ms_product_uom');
        $ret = $query->row_array();

        return $ret;
    }

    function getMeasure($productId)
    {
        $ret = "";
        $this->db->select("unit_id, measure");
        $this->db->where('product_id', $productId);

        $query = $this->db->get('ms_product_uom');
        $ret = $query->result_array();

        return $ret;
    }
}
?>