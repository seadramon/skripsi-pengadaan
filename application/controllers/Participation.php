<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Participation extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        $this->load->model('participation_model');
	}

	public function index()
	{
        // print_r($this->session->userdata('spgConnected'));
		if ($this->session->userdata('spgConnected')['userId']!="") {
			$dataParticipant = $this->pagination_code();
            $jmlMenang = $this->participation_model->jumlah();
            $jmlKalah = $this->participation_model->jumlah('4');
            $searchBy = array('users.name' => 'Nama',
                              'mall.name' => 'Mall',
                              'phone' => 'No.Telp',
                              'email' => 'Email',
                              'prize.name' => 'Hadiah');

			$data = array('dataParticipant' => $dataParticipant,
                          'jmlPeserta' => $dataParticipant['jmlPeserta'],
                          'jmlMenang' => $jmlMenang,
                          'jmlKalah' => $jmlKalah,
                          'searchBy' => $searchBy);
			$this->load->view('frontend/participation', $data);
		} else {
			$this->load->view('frontend/home');
		}
	}

	public function indexMirror()
	{
		$dataParticipant = $this->pagination_code();
		$data = array('dataParticipant' => $dataParticipant);

		$this->load->view('frontend/ajaxParticipant', $data);
	}

    public function eksport($to = "excel")
    {
        $userId = $this->session->userdata('spgConnected')['userId'];
        $query = $this->participation_model->getParticipant($userId);
        if (count($query) > 0) {
            $data = array('groups' => $query,
                          'title' => 'Report Participant');
            $nama = "ReportParticipant.xls";

            header(sprintf("Content-Disposition: attachment; filename=%s", $nama));
            $this->load->view('frontend/reportParticipant', $data);
        }
    }

	public function pagination_code($status = 0)
    {

        $userId = $this->session->userdata('spgConnected')['userId'];
        $key = array();
        $searchBy = null;
        $searchVal = null;
        $from = null;
        $to = null;
        // DropSearch
        $data['searchBy'] = array('users.name' => 'Nama',
                              'mall.name' => 'Mall',
                              'phone' => 'No.Telp',
                              'email' => 'Email',
                              'prize.name' => 'Hadiah');
        // Search Post
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $key = purify($this->input->post());
            $searchBy = isset($key['searchBy'])?$key['searchBy']:null;
            $searchVal = isset($key['searchVal'])?$key['searchVal']:null;
            $from = isset($key['from'])?$key['from']:null;
            $to = isset($key['to'])?$key['to']:null;
        }
        //pagination
        $page_number = $this->uri->segment(3);
        $page_url = $config['base_url'] = base_url() . 'participation/indexMirror/';

        $config['uri_segment'] = 3;

        $config['per_page'] = 10;
        $config['num_links'] = 5;
        if (empty($page_number)) {
            $page_number = 1;
        }
        $offset = ($page_number - 1) * $config['per_page'];
        /*echo $offset;die();*/

        $config['use_page_numbers'] = true;
        $data["myCode"] = $this->participation_model->getParticipant($userId, $searchBy, $searchVal, $from, $to, $config['per_page'], $offset);
        $config['total_rows'] = $this->participation_model->getTotalParticipant($searchBy, $searchVal, $from, $to);
        $data['jmlPeserta'] = $config['total_rows'];

        $page_url = $page_url . '/' . $page_number;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lsaquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&rsaquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="' . $page_url . '">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&raquo;';

        // $this->pagination->cur_page = $offset;
        $config['cur_page '] = $offset;

        $this->pagination->initialize($config);
        $data['page_links'] = $this->pagination->create_links();

        return $data;
    }
}
?>