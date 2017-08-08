<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function dd($var)
{
    echo '<pre>';
    print_r ($var);
    echo '</pre>';
    exit();
}

function getExtension ($mime_type){
    $extensions = array('image/jpeg' => 'jpg',
                        'text/xml' => 'xml',
                        'image/png' => 'png',
                        'image/gif' => 'gif');

    // Add as many other Mime Types / File Extensions as you like
    return isset($extensions[$mime_type])?$extensions[$mime_type]:"";
}

function slug($text, $space)
{
    // replace non letter or digits by -
     $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', $space, $text);

    //replace space
    // $text = str_replace(' ', '_', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
       return 'n-a';
    }

    return $text;
}

function assets_folder($dir = '' )
{
    return base_url() . 'assets' . ($dir != '' ? '/' . $dir : '') . '/';
}

/**
 * get administrator folder
 * @return string cms folder
 */
function admin_folder() {
    $CI =& get_instance();
    $return = $CI->config->item('admin_folder');
    return $return;
}

/**
 * get administrator url
 * @return string cms folder
 */
function admin_url() {
    return site_url(admin_folder());
}

/**
 * retrieve session of admin user id
 * @author latada
 * @return string admin user id
 */
function adm_sess_userid() {
    $CI =& get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS')=='') $sess = 0;
    else {
        $ADM_SESS = $CI->session->userdata('ADM_SESS');
        $sess = $ADM_SESS['nik'];
    }
    return $sess;
}

/**
 * retrieve session of admin user group id
 * @author latada
 * @return string admin user group id
 */
function adm_sess_usergroupid() {
    $CI=& get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS')=='') $sess = 0;
    else {
        $ADM_SESS = $CI->session->userdata('ADM_SESS');
        $sess = $ADM_SESS['group_id'];
    }
    return $sess;
}

/**
 * insert log user activity to database
 * @author latada
 * @param $data data array to insert
 */
function insert_to_log($data) {
    # load ci instance
    $CI=& get_instance();
    $CI->load->database();

    $CI->db->insert('logs', $data);
}

function getBantuanTerkumpul($id_insiden)
{
    $table = "bantuan";
    $child_table = "detail_bantuan";
    $child_table2 = "danabantuan";

    $CI=& get_instance();
    $CI->load->database();

    $CI->db->where('bantuan.id_insiden', $id_insiden);
    $CI->db->select('sum((detail_bantuan.quantity_received * kebutuhan.harga_satuan)) as nilaiBantuanDrop,
sum(danabantuan.quantity) as nilaiBantuanDana');
    $CI->db->from($table);
    $CI->db->join($child_table, $table.'.id_bantuan = detail_bantuan.id_bantuan', 'left');
    $CI->db->join($child_table2, $table.'.id_bantuan = danabantuan.id_bantuan', 'left');
    $CI->db->join('kebutuhan', $child_table.'.id_kebutuhan = kebutuhan.id_kebutuhan', 'left');
    $CI->db->join('item', 'kebutuhan.id_item = item.id_item', 'left');
    $CI->db->join('tipe', 'kebutuhan.id_tipe = tipe.id_tipe', 'left');

    $query = $CI->db->get();

    return $query->row_array();
}

/**
 * generate alert box notification with close button
 * @author latada
 * @param string $msg notification message
 * @param string $type type of notofication
 * @return string notification with html tag
 */
function alert_box($msg='', $type='') {
    $html = '';
    switch (strtolower($type)) {
        case 'info':
            $header = '<h4>	<i class="icon fa fa-info"></i> Info!</h4>';
            break;
        case 'success':
            $header = '<h4>	<i class="icon fa fa-check"></i> Success!</h4>';
            break;
        case 'warning':
            $header = '<h4>	<i class="icon fa fa-warning"></i> Warning!</h4>';
            break;
        case 'danger':
        case 'error':
            $header = '<h4>	<i class="icon fa fa-ban"></i> Error!</h4>';
            break;
        default:
            $header = '';
    }
    if ($msg != '' && $header != '') {
        if ($type == 'error') {
            $type = 'danger';
        }
        $html .= '<div class="alert alert-'.$type.' alert-dismissable">';
        $html .= '<button class="close" data-close="alert" data-dismiss="alert" aria-hidden="true">×</button>';
        $html .= $header;
        $html .= '<span>' . $msg . '</span>';
        $html .= '</div>';
    }
    return $html;
}

/**
 * global function for pagination
 * @author latada
 * @param $total_records total records data
 * @param $perpage showing total data per page
 * @param $path  path url
 * @param $uri_segment get from uri segment
 * @return string print pagination
 */
function global_paging($total_records, $perpage, $path, $uri_segment) {
    # load ci instance
    $CI =& get_instance();
    $CI->load->library('pagination');
    $config['base_url'] = $path;
    $config['total_rows'] = $total_records;
    $config['per_page'] = $perpage;
    $config['num_links'] = 5;
    $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-left">';
    $config['full_tag_close'] = '</ul>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['uri_segment'] = $uri_segment;
    $CI->pagination->initialize($config);
    $paging = $CI->pagination->create_links();
    return $paging;
}
/**
 *
 * @param int $id_user
 * @return int super admin status
 */
function adm_is_superadmin($id) {
    $return = 0;
    $CI=& get_instance();
    $CI->load->database();
    $CI->db->where('nik', $id);
    $CI->db->where('status', 1);
    $CI->db->limit(1);
    $query = $CI->db->get('karyawan');
    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        $return = '1';
    }
    return $return;
}

/**
 *
 * @param int $id_group
 * @return int super admin group status
 */
function adm_group_is_superadmin($id) {
    $return = 0;
    $CI=& get_instance();
    $CI->load->database();
    $CI->db->where('id', $id);
    $CI->db->limit(1);
    $query = $CI->db->get('group');
    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        $return = $row['is_superadmin'];
    }
    return $return;
}

/**
 * sort management
 * @param type $id_menu
 * @param type $urut
 * @param type $id_parents_menu
 * @param type $path_app
 * @param type $sort
 * @return string $return
 */
function sort_arrow($id_menu, $urut, $id_parents_menu, $path_app, $sort) {
    if ($sort == 'down') {
        $img = 'desc.gif';
    } else {
        $img = 'asc.gif';
    }
    $return = '<a href="javascript:;" id="sort_'.$sort.'-'.$id_menu.'" onclick="javascript:change_sort(\''.$urut.'\',\''.$id_menu.'\',\''.$id_parents_menu.'\',\''.$sort.'\',\''.$path_app.'\')">
            <img src="'.base_url().'assets/admin/img/'.$img.'">
    </a>';
    return $return;
}

/**
 * check admin session authorization, return true or false
 * @author latada
 * @return redirect to cms login page
 */
function auth_admin() {
    $CI =& get_instance();

    $sess = $CI->session->userdata('ADM_SESS');
    if (base_url() != $sess['url']) {
        $CI->session->unset_userdata('ADM_SESS');
        $CI->session->set_userdata('tmp_login_redirect', current_url());
        redirect(admin_folder().'/login');
    }
}

function auth_user() 
{
    $CI =& get_instance();
    $sess = $CI->session->userdata('karyawan');
    if (!$sess) {
        $CI->session->set_userdata('tmp_url', current_url());
        redirect(base_url().'users/login');
    }
}

/**
 * check authentication user by group id and menu id
 * @author latada
 * @param $id_group admin group id
 * @param $menu_name path menu or controller
 * @return true or false
 */
function auth_access_validation($group_id, $menu_name) {
    $CI =& get_instance();
    $CI->load->database();

    $CI->db->select('auth_pages.group_id, auth_pages.menu_id, menu.file');
    $CI->db->join('menu', 'menu.id = auth_pages.menu_id', 'left');
    $CI->db->where('auth_pages.group_id', $group_id);
    $CI->db->where('menu.file', $menu_name);
    $query = $CI->db->get('auth_pages');
    if ($query->num_rows()>0) {
        return true;
    } else {
        return false;
    }
}

/**
 * check if user admin is logged
 * @author latada
 * @return redirect to profile page
 */
function admin_is_loged() {
    $CI =& get_instance();
    $CI->load->library('session');
    if($CI->session->userdata('ADM_SESS') != '') {
        redirect(admin_folder() . '/home');
    }
}

/**
 * retrieve setting value by key
 * @author latada
 * @param $config_key field key
 * @param $id_site (optional) site id
 * @return string value
 */
function get_setting($config_key='',$id_site=8) {
    # load ci instance
    $CI=& get_instance();
    $CI->load->database();
    $val = '';
    if ($config_key != '') $CI->db->where('type',$config_key);
    $CI->db->where('id_site',$id_site);
    $query = $CI->db->get('setting');

    if ($query->num_rows()>1) {
        $val = $query->result_array();
    } elseif($query->num_rows()==1) {
        $row = $query->row_array();
        $val = $row['value'];
    }
    return $val;
}

/**
 * retrieve menu admin title
 * @author latada
 * @param $key key menu file, returning blank if empty/false
 * @return string title value
 */
function get_admin_menu_title($key) {
    # load ci instance
    $CI=& get_instance();
    $CI->load->database();

    $CI->db->where('file', $key);
    $CI->db->limit(1);
    $CI->db->order_by('id', 'desc');
    $query = $CI->db->get('menu');

    if ($query->num_rows()>0) {
        $row = $query->row_array();
        return $row['name'];
    } else {
        return '';
    }
}

/**
 * retrieve menu admin id
 * @author latada
 * @param $key key menu file, returning blank if empty/false
 * @return int id menu value
 */
function get_admin_menu_id($key) {
    # load ci instance
    $CI =& get_instance();
    $CI->load->database();

    $CI->db->where('file', $key);
    $CI->db->limit(1);
    $CI->db->order_by('id', 'desc');
    $query = $CI->db->get('menu');

    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        return $row['id'];
    } else {
        return '0';
    }
}


/**
 * upload image to destination folder, return file name
 * @author latada
 * @param $source_file string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 * @return string of edited file name
 */
function image_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_pic['tmp_name']);
    $source_pic_name = $source_pic['name'];
    $source_pic_tmpname  = $source_pic['tmp_name'];
    $source_pic_size = $source_pic['size'];
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];

    $x_ratio  = $max_width / $source_pic_width;
    $y_ratio  = $max_height / $source_pic_height;

    if( ($source_pic_width <= $max_width) && ($source_pic_height <= $max_height) )
    {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    }
    elseif (($x_ratio * $source_pic_height) < $max_height)
    {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    }
    else
    {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF)
            {
                $src = imageCreateFromGIF($source_pic['tmp_name']) ;
                $destination_folder.="$filename.gif";
                //$destination_folder.=$filename;
                $namafile ="$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG)
            {
                $src = imageCreateFromJPEG($source_pic['tmp_name']) ;
                $destination_folder.="$filename.jpg";
                //$destination_folder.=$filename;
                $namafile ="$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG)
            {
                $src = imageCreateFromJPEG($source_pic['tmp_name']) ;
                $destination_folder.="$filename.jpg";
                //$destination_folder.=$filename;
                $namafile ="$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG)
            {
                $src = imageCreateFromPNG($source_pic['tmp_name']) ;
                $destination_folder.="$filename.png";
                //$destination_folder.=$filename;
                $namafile ="$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP)
            {
                $src = imageCreateFromWBMP($source_pic['tmp_name']) ;
                $destination_folder.="$filename.bmp";
                //$destination_folder.=$filename;
                $namafile ="$filename.bmp";
            }
            break;
    }

    //chmod($destination_pic,0777);
    $tmp = imagecreatetruecolor($tn_width,$tn_height);
    imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$source_pic_width,$source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp,$destination_folder,100);
            break;

        case 'image/gif':
            imagegif($tmp,$destination_folder,100);
            break;

        case 'image/png':
            imagepng($tmp,$destination_folder);
            break;

        default:
            imagejpeg($tmp,$destination_folder,100);
            break;
    }

    return ($namafile);
}

/**
 * @param string $deviceToken
 * @param string $message
 */
function send_apn_async($deviceToken, $message)
{
	$message = urlencode($message);
	$url = base_url() . "api/send_apns?deviceToken=$deviceToken&message=$message";
	exec("curl '$url' 2>/dev/null");
}

/**
 * @param array $data
 */
function send_json($data)
{
	header('Content-Type: application/json');
	echo json_encode($data, JSON_PRETTY_PRINT);
}

/**
 * @param string $destNumber
 * @param string $msg
 */
function send_sms($destNumber, $msg) {
    $CI =& get_instance();
    $userkey = $CI->config->item('zenziva_userkey');
    $passkey = $CI->config->item('zenziva_passkey');

    $url = 'https://alpha.zenziva.net/apps/smsapi.php?userkey='. $userkey .'&passkey='. $passkey .'&nohp='. $destNumber .'&pesan=' . urlencode($msg);
    exec("curl '$url' > /dev/null &");
}

/**
 * @param string $language
 */
function set_lang($language = 'id') {
    if ($language != 'id' && $language != 'en') $language = 'id'; //Set default language
    $CI =& get_instance();
    $CI->session->set_userdata('lang', $language);
}

function get_lang() {
    $CI =& get_instance();

    if (!$CI->session->userdata('lang')) {
        set_lang();
    }

    return $CI->session->userdata('lang');
}

function get_combobox($query, $key, $value, $empty = "", &$disable = "")
{
	$combobox = array();
	$CI=& get_instance();
	$data = $CI->db->query($query);
	if($empty) $combobox[""] = $empty;
	if($data->num_rows() > 0){
		$kodedis = "";
		$arrdis = array();
		foreach($data->result_array() as $row){
			if(is_array($disable)){
				if($kodedis==$row[$disable[0]]){
					if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;".$row[$value];
				}else{
					if(!array_key_exists($row[$disable[0]], $combobox)) $combobox[$row[$disable[0]]] = $row[$disable[1]];
					if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;".$row[$value];
				}
				$kodedis = $row[$disable[0]];
				if(!in_array($kodedis, $arrdis)) $arrdis[] = $kodedis;
			}else{
				$combobox[$row[$key]] = $row[$value];
			}
		}
		$disable = $arrdis;
	}
	return $combobox;
}

function arrGender()
{
    $result = array('-'         => 'Pilih Jenis Kelamin',
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan');
    return $result; 
}

function date_dropdown($year_limit = 0)
{
    $html_output = '';
     /*days*/
    $html_output .= '           <select name="date_day" id="day_select">'."\n";
        for ($day = 1; $day <= 31; $day++) {
            $html_output .= '               <option>' . $day . '</option>'."\n";
        }
    $html_output .= '           </select>'."\n";

    /*months*/
    $html_output .= '           <select name="date_month" id="month_select" >'."\n";
    $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for ($month = 1; $month <= 12; $month++) {
            $html_output .= '               <option value="' . $month . '">' . $months[$month] . '</option>'."\n";
        }
    $html_output .= '           </select>'."\n";

    /*years*/
    $html_output .= '           <select name="date_year" id="year_select">'."\n";
        for ($year = 1900; $year <= (date("Y") - $year_limit); $year++) {
            $html_output .= '               <option>' . $year . '</option>'."\n";
        }
    $html_output .= '           </select>'."\n";

    $html_output .= '   </div>'."\n";

    return $html_output;
}

function uuid() 
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    // 16 bits for "time_mid"
    mt_rand(0, 0xffff),
    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand(0, 0x0fff) | 0x4000,
    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand(0, 0x3fff) | 0x8000,
    // 48 bits for "node"
    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function sendmail($arrdata = array())
{
    if (count($arrdata) > 0) {
        $CI =& get_instance();
        $CI->load->library('email');

        $subject = isset($arrdata['subject'])?$arrdata['subject']:""; 
        $message = isset($arrdata['message'])?$arrdata['message']:"";
        $to = isset($arrdata['to'])?$arrdata['to']:"";
         
        $email = $CI->email
                ->from('margi.landshark@gmail.com', 'Bantuin')
                ->to($to)
                ->subject($subject)
                ->message($message);
         
        if (!$email->send()) {
            return false;
        } else {
            return true;
        }
    }

    return false;
}


function phoneFormat($phone = "")
{
    $formated = '0';
    if ($phone!="") {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1)=='0') {
            $formated = '62'.substr($phone, 1);
        } elseif (substr($phone, 0, 2)=='62') {
            $formated = $phone;
        } else {
            $formated = '62'.$phone;
        }
    }
    return $formated;
}

function check_dateRange($startDate, $endDate, $varDate)
{
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
    $varDate = strtotime($varDate);

    return (($varDate >= $startDate) && ($varDate <= $endDate));
}

function auto_inc($table)
{
    $CI=& get_instance();
    $query = sprintf("SELECT AUTO_INCREMENT as urut
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = 'db_pengadaan'
        AND TABLE_NAME = '%s'", $table);
    $data = $CI->db->query($query)->row_array();

    return (int)$data['urut'];
}

function validateDetail($table, $col, $idbarang, $id)
{
    $CI=& get_instance();
    $CI->db->where($col, $id);
    $CI->db->where('idbarang', $idbarang);
    $CI->db->select('COUNT(idbarang) as total');
    $query = $CI->db->get($table)->row_array();

    $total = isset($query['total'])?$query['total']:0;
    return $total;
}

function terbilang($x)
{
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    switch ($x) {
        case $x < 12:
            return " " . $abil[$x];     
            break;
        case $x < 20:
            return Terbilang($x - 10) . "belas";
            break;
        case $x < 100:
            return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
            break;
        case $x < 200:
            return " seratus" . Terbilang($x - 100);
            break;
        case $x < 1000:
            return Terbilang($x / 100) . " ratus" . Terbilang($x % 100); 
            break;
        case $x < 2000:
            return " seribu" . Terbilang($x - 1000);
            break;
        case $x < 1000000:
            return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
            break;
        case $x < 1000000000:
            return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
            break;
    } 
}