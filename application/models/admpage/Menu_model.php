<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {
    
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->folder 	 = admin_folder();
    }

    /**
     * insert admin menu
     * @param type $data
     * @return type integer $id last inserted id admin menu
     */
    function insert($data)
    {
        $this->db->insert('menu',$data);
        $id = $this->db->insert_id();
        return $id;
    }
    
    /**
     * get menu admin by path file
     * @param type $file
     * @return type string $query
     */
    function GetMenuAdminByFile($file)
    {
        $this->db->where('file', $file);
        $this->db->limit(1);
        $this->db->order_by('id','desc');
        // $this->db->isdebug(TRUE);
        $query = $this->db->get('menu');
        
        return $query;
    }

    /**
     * get admin menu list option
     * @param int $id_parent
     * @param int $is_superadmin
     * @return string $query 
     */
    function getAdminMenuList($parent_id = 0)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('urut', 'asc');
        $query = $this->db->get('menu');
        return $query;
    }

    /**
     * get menu admin by group
     * @param type $group
     * @param type $parent
     * @return type 
     */
    function getMenuByGroup($group_id, $parent_id = 0)
    {
        $this->db->select('menu.*, auth_pages.menu_id, auth_pages.group_id');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('auth_pages.group_id', $group_id);
        $this->db->order_by('menu.urut', 'asc'); 
        $this->db->order_by('menu.parent_id', 'asc');
        $this->db->join('auth_pages', 'auth_pages.menu_id = menu.id', 'inner');
        $query = $this->db->get('menu');

        return $query;
    }

    /**
     * get menu admin by group
     * @param type $group
     * @param type $parent
     * @return type
     */
    function hasChild($group_id)
    {
        $this->db->where('parent_id', $group_id);
        $query = $this->db->get('menu');

        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }

    /**
     * check menu admin child
     * @param int $group
     * @param int $parent
     * @return bool true/false 
     */
    function CheckMenuChild($group_id, $parent_id = 0)
    {
        $this->db->where('parent_id', $group_id);
        $this->db->where('auth_pages.id_auth_user_group', $parent_id);
        $this->db->order_by('menu.urut', 'asc'); 
        $this->db->order_by('menu.parent_id', 'asc');
        $this->db->join('auth_pages', 'auth_pages.menu_id = menu.id','left');
        $query = $this->db->get("menu_admin");

        if ($query->num_rows()>0) return true;
        else return false;
    }
    
    /**
     * get all front static menu
     * @param int $id_parent
     * @return string $query
     */
    function getAllFrontMenu($id_parent=0) { 
        $this->db->where('is_delete',0);
        $this->db->where('id_parent_pages',$id_parent);
        $this->db->order_by('urut','asc');
        $query = $this->db->get('static_pages');
        return $query;
    }
    
    /**
     * get all admin menu
     * @param string $search
     * @param int $is_superadmin
     * @param int $limit
     * @param int $perpage
     * @return string $query
     */
    function getAllAdminMenu($name = '', $limit = 0, $perpage = 0)
    {
        $this->db->order_by('urut','asc');
        if ($name != '') $this->db->like('LOWER(name)', strtolower($name));
        $this->db->limit($perpage, $limit);
        $query = $this->db->get('menu');
        return $query;
    }

    /**
     * get menu admin title by file path
     * @param type $file
     * @return type string admin menu title
     */
    function getMenuAdminTitle($file)
    {
        $this->db->where('file',$file);
        $this->db->limit(1);
        $this->db->order_by('id','desc');
        $query = $this->db->get("menu_admin");

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['menu'];
        } else {
            return '';
        }
    }

    /**
     * get total admin menu
     * @param string $search
     * @param int $is_superadmin
     * @return int $total total record 
     */
    function getTotalAdminMenu($search = '')
    {
        $this->db->select('count(*) as total');
        if ($search != '') $this->db->like('LOWER(name)', strtolower($search));
        $query = $this->db->get('menu');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['total'];
        } else {
            return '0';
        }
    }

    /**
     * get parent name by id parent
     * @param type $id_parent
     * @return type string parent name
     */
    function getParentNameById($id_parent)
    {
        $this->db->order_by('urut','asc');
        $this->db->limit(1);
        $this->db->where('id',$id_parent);
        $query = $this->db->get('menu');
        if ($query->num_rows()>0) {
            $row = $query->row_array();
            return $row['name'];
        } else {
            return 'ROOT';
        }
    }
    
    /**
     * get reference urut for sort
     * @param type $id_parent
     * @return type string maximum field urut
     */
    function GetRefUrut($parent_id = null)
    {
        $this->db->select('max(urut) as urut');
        if ($parent_id) $this->db->where('parent_id',$parent_id);
        $query = $this->db->get('menu');
        return $query;
    }
    
    /**
     * get reference urut for sort
     * @param type $id_parent
     * @return type string maximum field urut
     */
    function GetRefUrutMax($parent_id = null)
    {
        $this->db->select('max(urut) as urut');
        if ($parent_id) $this->db->where('parent_id' ,$parent_id);
        $query = $this->db->get('menu');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['urut'];
        } else {
            return '0';
        }
    }

    /**
     * get reference minimum urut for sort
     * @param type $id_parent
     * @return type string minimum field urut
     */
    function GetRefUrutMin($parent_id = null)
    {
        $this->db->select('min(urut) as urut');
        if ($parent_id) $this->db->where('parent_id', $parent_id);
        $query = $this->db->get('menu');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['urut'];
        } else {
            return '0';
        }
    }

    /**
     * delete admin menu by id admin menu
     * @param type $Id 
     */
    function DeleteAdminMenu($Id=0)
    {
        $this->DeleteAuthMenu($Id);
        $this->db->where('id',$Id);
        $this->db->delete('menu');
    }

    /**
     * delete authentication admin menu by admin menu
     * @param type $id
     */
    function DeleteAuthMenu($menu_id)
    {
        $this->db->where('menu_id', $menu_id);
        $this->db->delete('auth_pages');

    }

    /**
     * get admin menu by id
     * @param type $Id
     * @return type string $query
     */
    function GetAdminMenuById($Id)
    {
        $this->db->where('id',$Id);
        $query = $this->db->get('menu');
        return $query;
    }

    /**
     * update admin menu
     * @param type $Id
     * @param type $data 
     */
    function UpdateAdminMenu($Id,$data)
    {
        $this->db->where('id',$Id);
        $this->db->update('menu',$data);
    }

    /**
     * change admin menu sort
     * @param type $id_page
     * @param type $parent_id
     * @param type $urut
     * @param type $direction 
     */
    function ChangeSort($id_page, $parent_id, $urut, $direction)
    {
        $this->db->where('id', $id_page);
        $this->db->where('parent_id', $parent_id);
        $this->db->where('urut', $urut);
        $this->db->order_by('urut', 'asc');
        $this->db->limit(1);
        $query = $this->db->get('menu');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            if($direction == 'down') {
                $this->db->where('urut > ', $urut);
                $this->db->order_by('urut', 'asc');
                $this->db->limit(1);
                $query_1 = $this->db->get('menu');
                if ($query_1->num_rows()>0) {
                    $row_1 = $query_1->row_array();

                    $this->UpdateAdminMenu($row_1['id'],array('urut'=>$urut));
                    $this->UpdateAdminMenu($id_page,array('urut'=>$row_1['urut']));
                }
            }
            elseif($direction == "up")
            {
                $this->db->where('urut < ',$urut);
                $this->db->order_by('urut','desc');
                $this->db->limit(1);
                $query_1 = $this->db->get('menu');
                if ($query_1->num_rows()>0)
                {
                    $row_1 = $query_1->row_array();

                    $this->UpdateAdminMenu($row_1['id'],array('urut'=>$urut));
                    $this->UpdateAdminMenu($id_page,array('urut'=>$row_1['urut']));
                }
            }
        }
    }

    /**
     * check admin menu by group id
     * @param type $id_group
     * @param type $menu_id
     * @return type boolean (true or false)
     */
    function CheckAdminMenuByGroupId($group_id, $menu_id)
    {
        $this->db->where('group_id', $group_id);
        $this->db->where('menu_id', $menu_id);
        $query = $this->db->get('auth_pages');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * get breadcrumbs menu
     * @param int $id_menu_parent
     * @return array menu 
     */
    function getBreadcrumbs($id_menu_parent) {
        $return = array();
        $this->db->where('id',$id_menu_parent);
        $this->db->limit(1);
        $this->db->order_by('urut','asc');
        $query = $this->db->get('menu');
        if ($query->num_rows()>0) {
            $row = $query->row_array();
            $href = ($row['file'] == '' || $row['file'] == '#') ? '#' : site_url(admin_folder().'/'.$row['file']);
            $return[] = array(
                'text'  => $row['name'],
                'href'  => $href,
                'class' => ''
            );
            $menu = $this->getBreadcrumbs($row['parent_id']);
            $return = array_merge($menu,$return);
        }
        return $return;
    }
    
    /**
     * get id menu by path/file
     * @param string $file
     * @return int 
     */
    function getAdminMenuIdByFile($file) {
        $this->db->where('file',$file);
        $this->db->where('file !=','#');
        $this->db->limit(1);
        $this->db->order_by('urut','asc');
        $query = $this->db->get('menu');
        if ($query->num_rows()>0) {
            $row = $query->row_array();
            return $row['parent_id'];
        } else {
            return '0';
        }   
    }
    
    /**
     * get disabled menu admin if there's any record set true, visa versa
     * @param int $id_menu
     * @return bool true/false 
     */
    function getDisabledMenuChild($id_menu,$disabled='') {
        $return = false;
        if ($disabled) {
            $this->db->where('parent_id',$id_menu);
            $this->db->order_by('urut','asc');
            $query = $this->db->get('menu');
            if ($query->num_rows()>0) {
                foreach($query->result_array() as $row) {
                    if ($row['id'] == $disabled) {
                        $return = true;
                        $disabled = $row['id'];
                    }
                    $this->getDisabledMenuChild($row['id'],$disabled);
                }
            }
        }
        return $return;
    }
    
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    
    function Get_Front_Page($id_site,$id_parent,$site_name,$prefix,$child=''){
        
        $this->db->select('site_url');
        $this->db->where('id_site',$id_site);
        $query = $this->db->get('sites');
        if($query->num_rows()>0) {
            $row = $query->row_array();
            $site_url=$row['site_url'];
            if($id_site==1){
                $site_url='navaplus';
            }
        }else{
            $site_url='';
        }
        
        $this->db->where('pages_sites.id_site', $id_site);
        $this->db->where('static_pages.is_delete', 0);
        $this->db->where('static_pages.id_parent_pages', $id_parent);
        $this->db->order_by('static_pages.urut', 'asc');
        $this->db->join('pages_sites', 'pages_sites.id_static_pages=static_pages.id_static_pages', 'left');
        $query = $this->db->get('static_pages');
        $print='';
        $open='';
        $key=$this->uri->segment(2);
        $asd=$this->uri->segment(3);
        if($key=='pages' && $asd !=''){
            $site=$this->uri->segment(4);
            if($asd =='edit'){
                $cek_site=$this->Cek_Site_Url_By_Id_Pages($site);
                $cek_menu_path=$this->Cek_Parent_By_Id($site);
                //echo $site_name.'-'.$cek_site.'<br>';
                if($site_name==$cek_site || $site_name==$cek_menu_path){
                    $open='in';
                }elseif($site==$id_parent){
                    $open='in';
                }    
            }
            
        }else{
            $site=$this->uri->segment(2);
            $cek_site=$this->Cek_Site_Url_By_Module($site);
            $cek_menu_path=$this->Cek_Parent_By_Id($cek_site['id_static_pages']);
            //echo $site_name.'-'.$cek_site['site_url'].'<br>';
            if($site_name==$cek_site['site_url'] || $site_name==$cek_menu_path){
                $open='in';
            }
        }
        
        //echo $site.'-'.$id_parent.'<br>';
        
        if($child){
            
            if($this->uri->segment(4)==$id_parent){
                $class='active';
            }else{
                $class='';
            }
            
            $print .='<div id="'.$site_url.'-'.$site_name.'" class="collapse '.$open.'">';
            $parent_url= site_url($this->folder.'/pages/edit/'.$id_parent);
            $print .='<a href="'.$parent_url.'"><button type="button" class="sub-sidenav '.$class.'">'.$prefix.'DESCRIPTION</button></a>';
        }else{
            $print .='<div id="'.$site_name.'" class="collapse '.$open.'">';
        }
        
        
        if($query->num_rows() > 0){

            foreach($query->result_array() as $row){
                
                $title=$row['title'];
                $page_type=$row['page_type'];
                $menu_path=$row['menu_path'];
                $module=$row['module'];
                
                //echo $site.'-'.$id_parent.'<br>';
                if($key=='pages'){
                    
                    if($site==$row['id_static_pages']){
                        $class='active';
                    }else{
                        $class='';
                    }    

                }else{
                    if($cek_site['id_static_pages']==$row['id_static_pages']){
                        $class='active';
                    }else{
                        $class='';
                    }   
                }
                
                if($page_type==1){
                    $url= site_url($this->folder.'/pages/edit/'.$row['id_static_pages']);
                }else{
                    $url = site_url($this->folder.'/'.$row['module']);	
                }
                    
                if($this->Cek_Menu_Child($row['id_static_pages'])){
                    $print .='<button type="button" class="sub-sidenav" data-toggle="collapse" data-target="#'.$site_name.'-'.$menu_path.'">';
                    $print .=$title.'<img src="'.base_url().'assets/images/admin/down.png" style="height:20px; float:right;"></button>';
                    
                    $print .=$this->Get_Front_Page($id_site,$row['id_static_pages'],$menu_path,'-- ','child');
                }else{
                    $print .='<a href="'.$url.'"><button type="button" class="sub-sidenav '.$class.'">'.$prefix.$title.'</button></a>';
                }
            }
        }
        $print .='</div>';
        return $print;
    }
    
    
    function Cek_Site_Url_By_Id_Pages($id_page){
        $sql="SELECT a.site_url,a.id_site FROM ".$this->db->dbprefix('sites a')." , ".$this->db->dbprefix('pages_sites b')." where b.id_static_pages =$id_page and b.id_site=a.id_site";
        $query	= $this->db->query($sql);
        if($query->num_rows() > 0){
            $detail=$query->row_array();
            $id_site=$detail['id_site'];
            
            if($id_site==1){
                $site_url='navaplus';
            }else{
                $site_url=$detail['site_url'];
            }
            
            return $site_url;
        }
    }
    
    
    function Cek_Parent_By_Id($id){

        $this->db->where('id_static_pages',$id);
        $this->db->where('is_delete',0);
        $this->db->where('id_ref_publish',1);
        $this->db->limit(1);
        $query=$this->db->get('static_pages');
        
        if($query->num_rows() > 0){
    
            $row=$query->row_array();
            if($row['id_parent_pages'] !=0){
                $this->db->where('id_static_pages',$row['id_parent_pages']);
                $this->db->where('is_delete',0);
                $this->db->where('id_ref_publish',1);
                $this->db->limit(1);
                $query=$this->db->get('static_pages');
                $asd=$query->row_array();
                return $asd['menu_path'];     
            }
            
        }
    }
    
    function Cek_Site_Name_By_Path($path){
        $sql="SELECT * FROM ".$this->db->dbprefix('sites a').", ".$this->db->dbprefix('pages_sites b').", ".$this->db->dbprefix('static_pages c')." where c.menu_path='$path' and c.id_static_pages=b.id_static_pages and b.id_site=a.id_site and c.is_delete=0";
        $query	= $this->db->query($sql);
        if($query->num_rows() > 0){
            $detail=$query->row_array();
            return $detail;
        }
    }
    
    function Cek_Menu_Child($id_parent){
       
        $this->db->where('static_pages.is_delete', 0);
        $this->db->where('static_pages.id_parent_pages', $id_parent);
        $this->db->order_by('static_pages.urut', 'asc');
        $this->db->join('pages_sites', 'pages_sites.id_static_pages=static_pages.id_static_pages', 'left');
        $query = $this->db->get('static_pages');

        if($query->num_rows() > 0){
            return true;
        }else{
            
            return false;
        }
    }
    
    function Cek_Site_Url_By_Module($module){
        $sql="SELECT * FROM ".$this->db->dbprefix('sites a').", ".$this->db->dbprefix('pages_sites b').", ".$this->db->dbprefix('static_pages c')." where c.module='$module' and c.id_static_pages=b.id_static_pages and b.id_site=a.id_site and c.is_delete=0";
        $query	= $this->db->query($sql);
        if($query->num_rows() > 0){
            $detail=$query->row_array();
            $id_site=$detail['id_site'];
            if($id_site==1){
                $detail['site_url']='navaplus';
            }else{
                
            }
            return $detail;
        }
    }
}

/* End of file menu_model.php */
/* Location: ./application/model/webcontrol/menu_model.php */


