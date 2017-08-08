<?php 
/**
* 
*/
class Generator_model extends CI_Model
{
	
	function __construct()
	{
		# code...
	}

	public function pictExist($title)
	{
		$this->db->select('COUNT(id) as jml');
		$this->db->where('post_title', $title);
		$this->db->from('wp_posttemp');
		$ret = $this->db->get()->row_array();

		return $ret['jml'];
	}

	public function post_nextId()
	{
		$this->db->select('MAX(ID) as maks');
		$this->db->from('wp_posttemp');
		$ret = $this->db->get()->row_array();

		return $ret['maks']+1;
	}

	public function insert_post($data)
	{
		$ret = $this->db->insert('wp_posttemp', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	public function wp_posttemp()
	{
		$ret = $this->db->get('wp_posttemp');
		return $ret->result_array();
	}

	public function insert_meta($data)
	{
		$ret = $this->db->insert('wp_postmetatemp', $data);
		return $ret; 
	}

	public function wp_post_meta($data)
	{
		$ret = $this->db->insert('wp_postmeta_temp', $data);
		return $ret;
	}
}