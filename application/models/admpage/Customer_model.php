<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Customer_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->site_id = $this->session->userdata('ADM_SESS')['site_id'];
	}

    function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
            if ($this->db->insert('ms_customer', $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('site_id', $this->site_id);
            $this->db->where('customer_id', $id);
            if ($this->db->update('ms_customer', $data)) {
                $result = 1;
            }
        }
        return $result;
    }

	function getById($id)
    {
        $this->db->select('ms_customer.*');
        $this->db->from('ms_customer');
        $this->db->where('ms_customer.site_id', $this->site_id);
        $this->db->where('ms_customer.customer_id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query;
    }

	function getTotal()
    {
        $total = 0;
        $this->db->select('COUNT(customer_id) as total');
        $this->db->where('site_id', $this->site_id);
        $query = $this->db->get('ms_customer')->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(ms_customer.name)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select(sprintf("ms_customer.*, ms_customer_group.customer_group_desc as cust_group, ms_customer.bill_to as test,
                        (select group_concat(distinct name) from ms_customer where site_id = '%s' AND customer_id = test) as bill_toDesc", 
                        $this->site_id));
        $this->db->where('site_id', $this->site_id);
        $this->db->from('ms_customer');
        $this->db->join('ms_customer_group', 'ms_customer.customer_group_id = ms_customer_group.customer_group_id', 'LEFT');
        $this->db->order_by('ms_customer.customer_id','desc');
        $query = $this->db->get();

        return $query;
    }

    function getCreditLimit($custId = "")
    {
        $this->db->select('ms_customer.name, ms_customer_credit_limit.*');
        $this->db->where('ms_customer_credit_limit.site_id', $this->site_id);
        if ($custId!="") {
            $this->db->where('ms_customer_credit_limit.customer_id', $custId);
        }
        $this->db->from('ms_customer_credit_limit');
        $this->db->join('ms_customer', 'ms_customer_credit_limit.customer_id = ms_customer.customer_id');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function getGroupId($custGroupId = "")
    {
        if ($custGroupId!="") {
            $this->db->where('customer_group_id', $custGroupId);
        }
        $query = $this->db->get('ms_customer_group')->result_array();
        return $query;
    }

    function maxCustId()
    {
        $ret = 0;
        $this->db->select('MAX(customer_id) as maks');
        $this->db->where('site_id', $this->site_id);
        $sql = $this->db->get('ms_customer')->row_array();
        $ret = isset($sql['maks'])?$sql['maks']:'0';

        return $ret;
    }
}
?>
