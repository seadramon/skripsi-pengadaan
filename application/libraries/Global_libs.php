<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_libs {
    private $folder;
    private $login_url;
    private $profile;
    private $arrGroup = array('master', 'sales', 'inventory', 'cash', 'report', 'showtable', 'laporan');
    
    /**
     * contructor
     */
    public function __construct() {
        $CI =& get_instance();
        $CI->load->library('parser');
        $CI->load->library('session');
        $CI->load->helper('url');
        $CI->load->database('default', true);

        $this->folder 	 = admin_folder();
        $this->login_url = 'login/logout';
        $this->profile 	 = 'profile';
		$ctrl = $CI->uri->segment(1);
		$fnct = $CI->uri->segment(2);
		if($ctrl == 'admpage' && !($fnct)) {
			redirect($ctrl . '/login');
		}
    }
    
    /**
     * get cms breadcrumbs
     * @param string $path_menu
     * @return array $return 
     */
    public function getBreadcrumbs($path_menu) {
        $CI =& get_instance();
        $CI->load->model(admin_folder().'/menu_model');
        $return[] = array(
            'text'  => 'Home',
            'href'  => site_url(admin_folder().'/home'),
            'class' => ''
        );
        $id_parent = $CI->menu_model->getAdminMenuIdByFile($path_menu);
        $menu = $CI->menu_model->getBreadcrumbs($id_parent);
        $return = array_merge($return,$menu);
        return $return;
    }
    
    /**
     * print header cms
     */
    public function print_header($group = "") {
        $CI =& get_instance();
        $CI->load->model(admin_folder() . '/menu_model');
        
        # auth access
        $this->auth_menu();

        $user_sess = $CI->session->userdata('ADM_SESS');
        $group_id  = $user_sess['group_id'];
        // $avatar = base_url() . 'uploads/avatars/' . $user_sess['avatar'];
        $name = $user_sess['nama'];

        $query = $CI->menu_model->getMenuByGroup($group_id);
        $admin_menu = '';
        $a = 0;

        foreach ($query->result_array() as $row) {
            $a++;
            if ($CI->menu_model->hasChild($row['id'])) {
                $admin_menu .= '<li class="treeview">';
                $icon = ($row['icon'] != '') ? '<i class="'.$row['icon'].'"></i>' : '';
                if ($row['file'] == '#' || $row['file'] == '') {
                    $admin_menu .= '<a href="javascript:;">'.$icon.'<span>'.$row['name'].'</span><i class="fa fa-angle-left pull-right"></i></a>';
                }

                $admin_menu .= $this->print_child_menu($group_id, $row['id']);

                $admin_menu .= '</li>';
            } else {
                $admin_menu .= '<li>';
                $icon = ($row['icon'] != '') ? '<i class="'.$row['icon'].'"></i>' : '';
                    $admin_menu .= '<a href="'.site_url($this->folder.'/'.$row['file']).'">'.$icon.'<span class="title">'.$row['name'].'</span></a>';
                $admin_menu .= '</li>';
            }
        }
        
        $logout_url  = site_url($this->folder.'/'.$this->login_url);
        $profile_url = site_url($this->folder.'/'.$this->profile);
        $data_header = array(
            'base_url'    => base_url(),
            'current_url' => current_url(),
            'logout_url'  => $logout_url,
            'profile_url' => $profile_url,
            // 'avatar'      => $avatar,
            'menu'        => $admin_menu,
            'head_title'  => get_setting('app_title'),
            'admin_name'  => $name
        );
        $CI->parser->parse($this->folder.'/layout/header', $data_header);
//        return $data_header;
    }

    /**
     * print child menu
     * @param int $id_group
     * @param int $id_parent
     * @param int $sub_menu
     * @return string $sub_menu sub menu
     */
    public function print_child_menu($group_id, $parent_id, $sub_menu='') {
        $CI=& get_instance();
        $CI->load->model(admin_folder().'/menu_model');
        $query = $CI->menu_model->getMenuByGroup($group_id, $parent_id);

        if ($query->num_rows()>0)
        {
            $sub_menu .= '<ul class="treeview-menu">';
            foreach($query->result_array() as $row)
            {
                $sub_menu .= '<li>';
                $icon = ($row['icon'] != '') ? '<i class="'.$row['icon'].'"></i>&nbsp;&nbsp;' : '';
                if ($row['file'] == "#" || $row['file'] == '') $sub_menu .= '<a href="#">'.$icon . $row['name'].'</a>';
                else  $sub_menu .= '<a href="'.site_url($this->folder.'/'.$row['file']).'">'.$icon . $row['name'].'</a>';

                $sub_menu .= $this->print_child_menu($group_id, $row['id']);

                $sub_menu .= '</li>';
                //$sub_menu .= '<li class="divider"></li>';
            }
            $sub_menu .= '</ul>';
        }
        return $sub_menu;
    }

    /**
     *
     * @param int $id_parent
     * @return string $tmp_return
     */
    public function print_front_menu($id_parent=0) {
        $tmp_return = '';
        $CI=& get_instance();
        $CI->load->model(admin_folder().'/menu_model');
        $query = $CI->menu_model->getAllFrontMenu($id_parent);
        if ($query->num_rows()>0) {
            foreach($query->result_array() as $row) {
                $tmp_return .= '<li>';
                if ($row['page_type'] == "2")
                {
                    $links = site_url($this->folder.'/'.$row['module']);
                } else {
                    if ($row['menu_path'] == '') {
                        $links = '#';
                    } else {
                        $links = site_url($this->folder.'/pages/edit/'.$row['id_static_pages']);
                    }
                }
                $tmp_return .= '<a href="'.$links.'">'.$row['menu_title'].'</a>';

                if ($this->front_menu_haschild($row['id_static_pages'])) {
                    $tmp_return .= '<ul>';
                    $tmp_return .= $this->print_front_menu($row['id_static_pages']);
                    $tmp_return .= '</ul>';
                } else {
                    $tmp_return .= $this->print_front_menu($row['id_static_pages']);
                }
            }
            $tmp_return .= '</li>';
        }
        return $tmp_return;
    }

    /**
     * check if front menu has child
     * @param int $id_parent
     * @return bool true/false
     */
    private function front_menu_haschild($id_parent) {
        $CI=& get_instance();
        $CI->load->model(admin_folder().'/menu_model');
        $query = $CI->menu_model->getAllFrontMenu($id_parent);
        if ($query->num_rows()>0) {
            return true;
        } else {
            return false;
        }
    }

    public function menu_front(){
	$print_front='';
	$CI=& get_instance();
	$CI->load->model(admin_folder().'/menu_model');
	$CI->load->model(admin_folder().'/Pages_model');
	$query=$CI->Pages_model->getAllSites();

	if ($query) {
		foreach($query as $row_site){
			$site_name = $row_site['site_name'];
			$site_url = ($site_name=="Nava+") ? 'navaplus' : $row_site['site_url'];
			$print_front .= '<button type="button" class="sidenav" data-toggle="collapse" data-target="#'.$site_url.'">';
			$print_front .= $site_name.'<img src="'.base_url().'assets/images/admin/down.png" style="height:20px; float:right;"></button>';
		}
	}

	return $print_front;

    }

    /**
     * print footer cms
     */
    public function print_footer() {
	    $CI =& get_instance();
        $data_footer['base_url']=base_url();
        $CI->parser->parse($this->folder.'/layout/footer', $data_footer);
    }
    
    /**
     * authenticate menu
     */
    public function auth_menu($set_session = 'ADM_SESS') {
		$CI=& get_instance();
        $CI->load->model(admin_folder().'/menu_model');
        $CI->load->model(admin_folder().'/group_model');

        $user_sess = $CI->session->userdata($set_session);
        if ($set_session == 'ADM_SESS') {
            $group_id 	 = $user_sess['group_id'];
        }

        if ($user_sess != '')  {
            $id_ref_menu = NULL;
            $ref_menu = $CI->uri->segment(2);
            $ref_menu_detail = $CI->uri->segment(3);

            if (in_array($CI->uri->segment(2), $this->arrGroup)) {
                $ref_menu = $CI->uri->segment(2).'/'.$CI->uri->segment(3);
                $ref_menu_detail = $CI->uri->segment(4);
            }
            
            $query = $CI->menu_model->GetMenuAdminByFile($ref_menu);
            
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $id_menu_admin = $row['id'];
                
                $query2 = $CI->group_model->GetMenuByRef($id_menu_admin, $group_id);
                
                if($query2->num_rows() == 0) {
                    show_404('page');
                }
            } else {
                if ($ref_menu != 'forbiden' && $ref_menu != 'home' && $ref_menu != 'profile' && $ref_menu != 'page404') {
                    show_404('page');
                }
            }
        }
    }
}
