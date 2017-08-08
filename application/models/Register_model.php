<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Register_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }

    function insert($arrCust = array(), $arrSubmission = array())
    {
        $result = 0;
        $id = 0;
        if (count($arrCust) > 0) {
            $this->db->insert('customer', $arrCust);
            $id = $this->db->insert_id();
            
            if (count($arrSubmission) > 0) {
                if ($id > 0) {
                    $arrSubmission['customer_id'] = $id;
                    $this->db->insert('submission', $arrSubmission);
                    if ($this->db->insert_id()) {
                        $result = $id;
                    }
                }
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id', $id);
            if ($this->db->update('customer', $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function getById($id)
    {
        $this->db->select('customer.*, kabupaten.nama as descity');
        $this->db->from('customer');
        $this->db->join('kabupaten', 'customer.city = kabupaten.id_kabupaten');
        $this->db->where('customer.id', $id);
        $this->db->order_by('customer.id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query;
    }

    function getTotal()
    {
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(customer.name)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $this->db->select('customer.*, kabupaten.nama as descity');
        $this->db->from('customer');
        $this->db->join('kabupaten', 'customer.city = kabupaten.id_kabupaten');
        $this->db->order_by('customer.id','desc');
        $query = $this->db->get();

        return $query;
    }

    function insert_newsletter($data = array())
    {
        $result = false;
        if (count($data) > 0) {
            $this->db->insert('newsletter', $data);
            if ($this->db->insert_id()) {
                $result = true;
            }
        }
        return $result;
    }

    function email_exist($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('newsletter');

        return $query->num_rows() > 0;
    }


    function insert_code($data = array())
    {
        $result = false;
        if (count($data) > 0) {
            $this->db->insert('submission', $data);
            if ($this->db->insert_id()) {
                $result = true;
            }
        }
        return $result;
    }

    function cekUser($phone = 0)
    {
        if ($phone!=0) {
            $ret = array();
            $this->db->select('customer.*, provinsi.nama as kota');
            $this->db->from('customer');
            $this->db->join('provinsi', 'customer.city = provinsi.id');
            $this->db->where('customer.phone', $phone);
            $ret = $this->db->get()->row_array();
            
            return $ret;
        }
    }
}
?>