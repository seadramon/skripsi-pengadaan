<?php
/**
* 
*/
class Aktivitas extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		auth_user();

		$this->path          = base_url() . 'aktivitas';
		$this->path_uri      = 'aktivitas';
		$this->ctrl          = 'aktivitas';

		$this->load->model('aktivitas_model');
		$this->load->model('insiden_model');
	}

	
    private $error;

    // array untuk validator
    private $arrForm = array('nama'  => 'Nama',
                        'alamat'  => 'Alamat',
                        'tgl_aktivitas'  => 'Tanggal Aktivitas');

    public function index($id)
	{
		$this->load->view('frontend/layout/header');
		$this->load->view('frontend/layout/nav');

		$this->main($id);

		$this->load->view('frontend/layout/footer');
	}

	public function main($id_insiden = "")
	{
		$this->session->set_userdata('referrer', current_url());

		$s_name		 = $this->uri->segment(5);
        $pg 		 = $this->uri->segment(6);
        $per_page 	 = 10;
        $uri_segment = 6;
        $no		 	 = 0;
        $path		 = $this->path.'/main/a/';
        $path_uri	 = $this->path_uri;
        $data_array  = array();
        $file_app	 = $this->ctrl;
        $path_app    = $this->path;
        $add_btn     = site_url($path_uri . '/add/'.$id_insiden);
        $back_btn	 = base_url().'insiden';
        
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
        $total_records = $this->aktivitas_model->getTotal($id_insiden, $s_name);
        $query = $this->aktivitas_model->getAll($id_insiden,  $s_name, $per_page, $lmt);
        foreach ($query->result_array() as $row) {
            $no++;
            $id             = $row['id_aktivitas'];
            $edit_href      = site_url($path_uri . '/edit/' . $id_insiden.'/'.$id);
            $detail_href      = site_url($path_uri . '/addDetail/' . $id_insiden.'/'.$id);

            $data_array[]   = array(
                'no'             => $no,
                'id'             => $id,
                'nama'           => isset($row['nama'])?$row['nama']:"-",
                'alamat'         => isset($row['alamat'])?$row['alamat']:"-",
                'tgl_aktivitas'  => isset($row['tgl_aktivitas'])?$row['tgl_aktivitas']:"-",
                'edit_href'      => $edit_href,
                'detail_href'    => $detail_href
            );
        }

        $dataId = $query->result_array();
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
            's_name'      => $s_name,
            'data'        => $data_array,
            'pagination'  => $paging,
            'error_msg'   => $error_message,
            'success_msg' => $success_msg,
            'info_msg'    => $info_msg,
            'path_uri'    => $path_uri,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'add_btn'     => $add_btn,
            'back_btn'    => $back_btn
        );
        $this->parser->parse('frontend/aktivitas/list', $data);
	}

	public function getForm($id_insiden, $id = "")
	{
        $this->load->view('frontend/layout/header');
        $this->load->view('frontend/layout/nav');

		$file_app         = $this->ctrl;
        $path_app         = $this->path;
        $path_uri         = $this->path_uri;
        $id               = $id;
        $error_message    = array();
        $post             = array();
        $image            = "";
        $akt_detail		  = array();
        $cancel_btn       = site_url($path_uri.'/index/'.$id_insiden);

        // Form attribute
        $akt_detail = $this->aktivitas_model->getFormDetail($id_insiden, $id);
        $this->load->model('admpage/tipe_model');
        $tipe = $this->tipe_model->showName();
        

        if ($id) {
            $query = $this->aktivitas_model->getById($id);
            if ($query->num_rows()>0) {
                $row = $query->row_array();
            } else {
                $this->session->set_flashdata('info_msg', 'There is no record in our database.');
                redirect($path_uri);
            }
        }


        if ($id) {
            $action = site_url($path_uri.'/edit/'.$id_insiden.'/'.$id);
        } else {
            $action = site_url($path_uri.'/add/'.$id_insiden);
        }

        // set warning
        if (isset($this->error['warning'])) {
            $error_message['warning'] = alert_box($this->error['warning'], 'warning');
        } else {
            $error_message['warning'] = '';
        }

        $arrForm = array('id_insiden',
                        'nama',
                        'alamat',
                        'deskripsi',
                        'tgl_aktivitas');
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
            } elseif (strlen($id)>0) {
                $post[$fieldName] = $row[$fieldName];
            } else {
                $post[$fieldName] = '';
            }
        }

        $post = array($post);
        $error_message = array($error_message);

        $data = array(
            'base_url'    => base_url(),
            'id_insiden'  => $id_insiden,
            'post'        => $post,
            'action'      => $action,
            'img'         => $image,
            'tipe'		  => $tipe,
            'f_detail'    => $akt_detail,
            'error_msg'   => $error_message,
            'file_app'    => $file_app,
            'path_app'    => $path_app,
            'path_uri'    => $path_uri,
            'cancel_btn'  => $cancel_btn
        );
        $this->parser->parse('frontend/aktivitas/create', $data);
        $this->load->view('frontend/layout/footer');
	}

	public function add($id_insiden)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->aktivitas_model->insert($post);            

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }
            redirect($this->path_uri.'/index/'.$id_insiden);

        }
        $this->getForm($id_insiden);
    }

    public function edit($id_insiden, $id = "") 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $post = purify($this->input->post());
            $this->replacer($post);

            $result = $this->aktivitas_model->update($id, $post);            

            if ($result==1) {
                $this->session->set_flashdata('success_msg', $this->title . ' has been added');
            } else {
                $this->session->set_flashdata('error_msg', $this->title . ' cannot be added');
            }

            redirect($this->path_uri.'/index/'.$id_insiden);
        }
        $this->getForm($id_insiden, $id);
    }

    private function validateForm()
    {
        $post = purify($this->input->post());

        foreach ($this->arrForm as $fieldName => $fieldValue) {
            if ($post[$fieldName]=='') {
                $this->error[$fieldName] = $fieldValue.' Cannot be empty';    
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function replacer(&$post)
    {
        if (is_array($post) && count($post) > 0) {
            $post['nama'] = ucwords($post['nama']);
        }
    }

    public function getFormDetail($id_insiden, $id_aktivitas)
	{
		$this->load->view('frontend/layout/header');
        $this->load->view('frontend/layout/nav');

        $error_message = array();
		$path_uri    = $this->path_uri;
        $this->load->model('admpage/tipe_model');
        $tipe = $this->tipe_model->showName();
        $akt_detail = $this->aktivitas_model->getFormDetail($id_insiden, $id_aktivitas);
        $action = site_url($path_uri.'/addDetail/'.$id_insiden.'/'.$id_aktivitas);

        if ($this->error) {
			foreach ($this->error as $key => $value) {
				$error_message[$key] = alert_box($value, 'error');
			}
		}
		$cancel_btn = site_url($path_uri.'/index/'.$id_insiden);

        $data = array('f_detail' => $akt_detail,
        			'tipe' => $tipe,
        			'action' => $action,
        			'id_aktivitas' => $id_aktivitas,
        			'error_msg'   => $error_message,
	            	'cancel_btn'  => $cancel_btn);

        $this->load->view('frontend/aktivitas/detail', $data);
        $this->load->view('frontend/layout/footer');
	}

	private function validateFormDetail()
	{
		$post = purify($this->input->post());

		if (count($post['detail']) > 0) {
			foreach ($post['detail'] as $key => $value) {
				if ($value['qty_sent']!='') {
					if (!ctype_digit($value['qty_sent'])) {
						$this->error['qty_sent'] = "Quantity harus dalam bentuk angka";
					} else {
						if ($value['qty_sent'] > $value['qty_tersedia']) {
							$this->error['qty_sent'] = "Quantity melebihi qty tersedia";	
						}
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

	private function replacerDetail(&$post)
    {
        if (is_array($post['detail']) && count($post['detail']) > 0) {
        	for ($i=0; $i < count($post['detail']); $i++) { 
        		unset($post['detail'][$i]['qty_tersedia']);
        		if ($post['detail'][$i]['qty_sent']=="") {
        			$post['detail'][$i]['qty_sent'] = 0;
        		}
        		$post['detail'][$i]['id_aktivitasdetail'] = uuid();
        	}
        }
    }

	public function addDetail($id_insiden, $id_aktivitas)
	{
		auth_user();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateFormDetail()) {
            $post = purify($this->input->post());

            $this->replacerDetail($post);
            $this->aktivitas_model->clearDetail($id_aktivitas);
            $result = $this->aktivitas_model->insertDetail($post['detail']);

            if ($result==1) {
            	$this->session->set_flashdata('success_msg', 'Detail Aktivitas berhasil disubmit');
            } else {
                $this->session->set_flashdata('error_msg', 'Maaf, Detail tidak dapat disubmit');
            }
            redirect($this->path_uri.'/index/'.$id_insiden);

        }

        $this->getFormDetail($id_insiden, $id_aktivitas);
	}

	public function editDetail($id_insiden, $id_aktivitas)
	{
		auth_user();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateFormDetail()) {
            $post = purify($this->input->post());
            $detail = array();
            $post['id_aktivitas'] = $id_aktivitas;

            $this->replacer($post);
            $this->aktivitas_model->clearDetail($id_aktivitas);
            $result = $this->aktivitas_model->insertDetail($post, $detail);     

            if ($result==1) {
            	$this->session->set_flashdata('success_msg', 'Detail berhasil diperbarui');            	
            } else {
                $this->session->set_flashdata('error_msg', 'Maaf, Detail tidak dapat diperbarui');
            }
            redirect($this->path_uri.'/index/'.$id_insiden);

        }

        $this->getFormDetail($id_insiden, $id_aktivitas);
	}

    public function delete()
    {
        if ($this->input->post('id')!= '') {
            if (strlen($this->input->post('id')) > 0) {
                    $id = $this->input->post('id');
                    if ($this->aktivitas_model->delete($id)) {
                        $this->session->set_flashdata('success_msg', 'aktivitas has been deleted.');
                    } else {
                        $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
                    }
            } else {
                $this->session->set_flashdata('error_msg', 'Delete failed. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Delete failed.ID empty. Please try again.');
        }
    }
}