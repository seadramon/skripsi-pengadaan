<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model {
    
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('group', $data);
        $id_auth_user_group = $this->db->insert_id();
        return $id_auth_user_group;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('group', $data);
    }

    function updatebyDivisi($id, $data)
    {
        $this->db->where('iddivisi', $id);
        $this->db->update('group', $data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('group');
    }

    function getTotal()
    {
        $query = $this->db->get('group');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getById($id)
    {
        $this->db->where('id', $id);
        $this->db->order_by('id','asc');
        $this->db->limit(1);
        $query = $this->db->get('group');
        return $query;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(name)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('group');
        return $query;
    }

    function insertAuthGroup($data)
    {
        $this->db->insert('auth_pages', $data);
    }

    function deleteAuthGroup($group_id)
    {
        $this->db->where('group_id', $group_id);
        $this->db->delete('auth_pages');

    }

    /**
     *
     * @param string $group_name
     * @param int $id
     * @return bool true/false 
     */
    function CheckExistsAdminGroup($group_name, $id=0)
    {
        if ($id) $this->db->where('id != ',$id);
        $this->db->where('name', $group_name);
        $query = $this->db->get('group');
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * @param int $parent_id
     * @param int $is_superadmin
     * @return string $query 
     */
    function getAllAdminMenu($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('menu');
        return $query;
    }

    /**
     *
     * @param int $group_id
     * @param int $id_admin_menu
     * @return bool $id_auth_pages 
     */
    function getAuthPages($group_id, $menu_id)
    {
        $this->db->where('group_id', $group_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->limit(1);
        $query = $this->db->get('auth_pages');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['id'];
        } else {
            return false;
        }
    }

    /**
     *
     * @param int $parent_id
     * @return string $query 
     */
    function GetMenuByParent($parent_id)
    {
        $this->db->where('id_parents_menu_admin',$parent_id);
        $query = $this->db->get('ref_menu_admin');
        return $query;
    }

    /**
     *
     * @param int $menu_id
     * @param int $group_id
     * @return object $query
     */
    function GetMenuByRef($menu_id, $group_id)
    {
        $this->db->where('menu_id', $menu_id);
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('auth_pages');
        return $query;
    }

}
