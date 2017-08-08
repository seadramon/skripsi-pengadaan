<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Customer extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		auth_admin();
		$this->load->model(admin_folder() . '/customer_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'master/customer';
        $this->template      = admin_folder() . '/master/customer/';
        $this->path_uri      = admin_folder() . '/master/customer';
        $this->path          = base_url() . admin_folder().'/master/customer';
        $this->title         = get_admin_menu_title('customer');
        $this->id_admin_menu = get_admin_menu_id('customer');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

    private $arrForm = array('name',
                         'address',
                         'phone1',
                         'customer_group_id',
                         'bill_to',
                         'current_credit_limit');
    private $error;

	public function index()
	{
		$this->main();
	}

	function main()
	{
		$this->session->set_userdata('referrer', current_url());
        $this->global_libs->print_header();

        $s_name		 = $this->uri->segment(5);
        $pg 		 = $this->uri->segment(6);
        $per_page 	 = 10;
        $uri_segment = 6;
        $no		 	 = 0;
        $path		 = $this->path.'/main/a/';
        $data_array  = array();
        $credit_array = array();
        $menu_title	 = $this->title;
        $file_app	 = $this->ctrl;
        $path_uri	 = $this->path_uri;
        $path_app	 = $this->path;
        $template	 = $this->template;
        $add_btn     = site_url($path_uri . '/add');
        $breadcrumbs = $this->global_libs->getBreadcrumbs($file_app);
        
        $breadcrumbs[] = array(
                'text'  => $menu_title,
                'href'  => '#',
                'class' => 'class="current"'
        );

        if (strlen($s_name) > 1) {
            $s_name = substr($s_name, 1);
        } else {
            $s_name = '';
        }

        if ($s_name) {
            $path = str_replace('/a/', '/a' . $s_name . '/', $path);
        }

        if (!$pg) {
            $lmt = 0;
            $pg = 1;
        } else {
            $lmt = $pg;
        }
        $no = $lmt;
        $total_records = $this->customer_model->getTotal($s_name);
        $query = $this->customer_model->getAll($s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['customer_id'];
            $edit_href      = site_url($path_uri . '/edit/' . $id);

            if ($row['status']=='1') {
                $statusDesc = 'active';
            } else {
                $statusDesc = 'non active';
            }

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'name'           => isset($row['name'])?$row['name']:"-",
                'phone1'         => isset($row['phone1'])?$row['phone1']:"-",
                'customer_group_id' => isset($row['customer_group_id'])?$row['customer_group_id']:"-",
                'cust_group'     => isset($row['cust_group'])?$row['cust_group']:"-",
                'current_credit_limit'=> isset($row['current_credit_limit'])?number_format($row['current_credit_limit']):"-",
                'bill_toDesc'    => isset($row['bill_toDesc'])?$row['bill_toDesc']:"-",
                'status'         => $statusDesc,
                'edit_href'      => $edit_href,
            );
        }

        $dataId = $query->result_array();
        // customer credit limit
        $custIdCreditLimit = isset($dataId[0]['customer_id'])?$dataId[0]['customer_id']:"";
        $sqlCreditLimit = $this->customer_model->getCreditLimit($custIdCreditLimit);
        $i = 0;
        foreach ($sqlCreditLimit as $row) {
            $i++;
            $credit_array[] = array('no' => $i,
                                    'site_id' => isset($row['site_id'])?$row['site_id']:"",
                                    'name' => isset($row['name'])?$row['name']:"",
                                    'customer_id' => isset($row['customer_id'])?$row['customer_id']:"",
                                    'credit_limit' => isset($row['credit_limit'])?$row['credit_limit']:"",
                                    'date_start' => isset($row['date_start'])?$row['date_start']:"");
        }

        // customer groupId
        $groupIdCustomerGroupId = isset($dataId[0]['customer_group_id'])?$dataId[0]['customer_group_id']:"";
        $sqlGroupId = $this->customer_model->getGroupId($groupIdCustomerGroupId);
        $i = 0;
        foreach ($sqlGroupId as $row) {
            $i++;
            $groupId_array[] = array('no' => $i,
                                    'customer_group_id' => isset($row['customer_group_id'])?$row['customer_group_id']:"",
                                    'customer_group_desc' => isset($row['customer_group_desc'])?$row['customer_group_desc']:"");
        }

        // paging
        $paging = global_paging($total_records, $per_page, $path, $uri_segment);
        if(!$paging) $paging = '<ul class="pagination pagination-sm no-margin pull-left"><li class="active"><a>1</a></li></ul>';
        //end of paging

        $error_message 	 = alert_box($this->session->flashdata('error_msg'), 'error');
        $success_msg = alert_box($this->session->flashdata('success_msg'), 'success');
        $info_msg 	 = alert_box($this->session->flashdata('info_msg'), 'warning');

        $data = array(
            'base_url'    => base_url(),
            'current_url' => current_url(),
            'menu_title'  => $menu_title,
            's_name'      => $s_name,
            'data'        => $data_array,
            'credit'      => $credit_array,
            'groupId'      => $groupId_array,
            'breadcrumbs' => $breadcrumbs,
            'pagination'  => $paging,
            'error_msg'   => $error_message,
            'success_msg' => $success_msg,
            'info_msg'    => $info_msg,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'add_btn'     => $add_btn,
        );
        $this->parser->parse($template.'customer', $data);
        $this->global_libs->print_footer();
	}

    public function custRelation($custId = "", $custGrupId = "")
    {
        $credit_array = array();
        $groupId_array = array();
        $template = $this->template;
        // customer credit limit
        $sqlCreditLimit = $this->customer_model->getCreditLimit($custId);
        $i = 0;
        foreach ($sqlCreditLimit as $row) {
            $i++;
            $credit_array[] = array('no' => $i,
                                    'site_id' => isset($row['site_id'])?$row['site_id']:"",
                                    'name' => isset($row['name'])?$row['name']:"",
                                    'customer_id' => isset($row['customer_id'])?$row['customer_id']:"",
                                    'credit_limit' => isset($row['credit_limit'])?$row['credit_limit']:"",
                                    'date_start' => isset($row['date_start'])?$row['date_start']:"");
        }

        // customer groupId
        $sqlGroupId = $this->customer_model->getGroupId($custGrupId);
        $i = 0;
        foreach ($sqlGroupId as $row) {
            $i++;
            $groupId_array[] = array('no' => $i,
                                    'customer_group_id' => isset($row['customer_group_id'])?$row['customer_group_id']:"",
                                    'customer_group_desc' => isset($row['customer_group_desc'])?$row['customer_group_desc']:"");
        }

        $data = array('credit' => $credit_array,
                      'groupId' => $groupId_array);
        $this->parser->parse($template.'custRelation', $data);
    }

	public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $post['customer_id'] = $this->autoInc();
            $post['phone2'] = '';
            // print_r($post);die();
            $result = $this->customer_model->insert($post);

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri);
        }
        $this->getForm();
    }

    public function edit($id = "")
    {
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Please try again with the right method.');
            redirect($this->template);
        }

        if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->validateForm($id) ) {
            $post = purify($this->input->post());
            $post['phone2'] = '';

            $result = $this->customer_model->update($id, $post);

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been updated');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be updated');
            }

            if ($this->session->userdata('referrer') != '') {
                redirect($this->session->userdata('referrer'));
            } else {
                redirect($this->path_uri);
            }
        }
        $this->getForm($id);
    }

    private function getForm($id = "")
    {
        $this->global_libs->print_header();

        $menu_title	= $this->title;
        $file_app	= $this->ctrl;
        $path_app	= $this->path;
        $path_uri	= $this->path_uri;
        $template	= $this->template;
        // $id		    = (int)$id;
        $error_message	= array();
        $post		= array();
        $image      = "";
        $cancel_btn = site_url($path_uri);
        $status = array('1' => 'active',
                        '0' => 'non active');

        $breadcrumbs    = $this->global_libs->getBreadcrumbs($file_app);

        $breadcrumbs[]  = array(
                'text'  => $menu_title,
                'href'  => site_url($path_uri),
                'class' => ''
        );

        if ($id) {
            $query = $this->customer_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }
        // print_r($query->row_array());
        if ($id) {
            $breadcrumbs[] = array(
                'text'  => 'Edit',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/edit/'.$id);
        } else {
            $breadcrumbs[] = array(
                'text'  => 'Add',
                'href'  => current_url().'#',
                'class'	=> 'class="current"'
            );
            $action = site_url($path_uri.'/add');
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('name',
        				 'address',
        				 'phone1',
        				 'customer_group_id',
                         'bill_to',
        				 'current_credit_limit');
        foreach ($arrForm as $fieldName) {
        	// set Error
        	if (isset($this->error[$fieldName])) {
            	$error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        } else {
	            $error_message[$fieldName] = '';
	        }

	        // set value
	        if ($this->input->post($fieldName) != '') {
	            $post[$fieldName] = $this->input->post($fieldName);
	        } elseif ((int)$id>0) {
	            $post[$fieldName] = $row[$fieldName];
	        } else {
	            $post[$fieldName] = '';
	        }
        }

        $post = array($post);
        $error_message = array($error_message);

        $data = array(
            'base_url'    => base_url(),
            'menu_title'  => $menu_title,
            'post'        => $post,
            'action'      => $action,
            'groupId'     => get_combobox("select customer_group_id, customer_group_desc from ms_customer_group", "customer_group_id", "customer_group_desc", true),
            'img'         => $image,
            'status'      => $status,
            'error_msg'   => $error_message,
            'breadcrumbs' => $breadcrumbs,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse($template . 'customer_form', $data);
        $this->global_libs->print_footer();
    }

    private function validateForm($id = 0)
    {
        $post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        foreach ($this->arrForm as $fieldName) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldName.' Cannot be empty';    
            } else {
                if ($fieldName=='phone1' || $fieldName=='current_credit_limit') {
                    if (!is_numeric($post[$fieldName])) {
                        $this->error[$fieldName] = $fieldName.' Must in Numeric';
                    }
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function autoInc()
    {
        $num = 0;
        $last = $this->customer_model->maxCustId();
        $last = ltrim($last, '0') + 1;
        $num = sprintf("%06d", $last);
        
        return $num;
    }
}
?>