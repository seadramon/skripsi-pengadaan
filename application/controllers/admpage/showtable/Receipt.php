<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_admin();
		$this->load->model(admin_folder() . '/receipt_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'showtable/supplier';
        $this->template      = admin_folder() . '/showtable/';
        $this->path_uri      = admin_folder() . '/showtable/supplier';
        $this->path          = base_url() . admin_folder().'/showtable/supplier';
        $this->title         = get_admin_menu_title('supplier');
        $this->id_admin_menu = get_admin_menu_id('supplier');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}

	public function getDocId()
	{
		$docList = $this->getPagination();
		$data = array('docList' => $docList);

		$this->load->view($this->template.'receiptHeader', $data);
	}

	public function getPagination()
	{
		$key = array();
		$searchBy = null;
		$searchVal = null;
		// DropSearch
		$data['searchBy'] = array('product_id' => 'Product ID',
								 'name' => 'Name',
								 'stock' => 'Stock',
								 'price' => 'Price');
		// Search Post
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$key = purify($this->input->post());
			$searchBy = isset($key['searchBy'])?$key['searchBy']:null;
			$searchVal = isset($key['searchVal'])?$key['searchVal']:null;
		}
	    //pagination
	    $page_number = $this->uri->segment(5);
	    $page_url = $config['base_url'] = base_url().'admpage/showtable/receipt/getDocId/';
	    $config['uri_segment'] = 5;

	    $config['per_page'] = 10;
	    $config['num_links'] = 5;
	    if(empty($page_number)) $page_number = 1;
	    $offset = ($page_number-1) * $config['per_page'];

	    $config['use_page_numbers'] = TRUE;
	    $data["product"] = $this->receipt_model->getAll($searchBy, $searchVal, $config['per_page'],$offset);
	    $config['total_rows'] = $this->receipt_model->getTotal($searchBy, $searchVal);

	    $page_url = $page_url.'/'.$page_number;

	    $config['full_tag_open'] = '<ul class="tsc_pagination pagination pagination-sm no-margin pull-left">';
	    $config['full_tag_close'] = '</ul>';
	    $config['prev_link'] = '&lt;';
	    $config['prev_tag_open'] = '<li>';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '&gt;';
	    $config['next_tag_open'] = '<li>';
	    $config['next_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active"><a href="'.$page_url.'">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';

	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li>';
	    $config['last_tag_close'] = '</li>';

	    $config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$config['num_links'] = 5;

	    $this->pagination->cur_page = $offset;

	    $this->pagination->initialize($config);
	    $data['page_links'] = $this->pagination->create_links();

	    return $data;
	}
}
?>