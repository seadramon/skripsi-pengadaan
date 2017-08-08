<?php 
class Receipt extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		auth_admin();
		$this->load->model(admin_folder() . '/receipt_model');
		$this->load->model(admin_folder() . '/product_model');
		$this->load->model(admin_folder() . '/stock_model');

        $this->folder        = admin_folder();
        $this->ctrl          = 'inventory/receipt';
        $this->template      = admin_folder() . '/inventory/receipt/';
        $this->path_uri      = admin_folder() . '/inventory/receipt';
        $this->path          = base_url() . admin_folder().'/inventory/receipt';
        $this->title         = get_admin_menu_title('receipt');
        $this->id_admin_menu = get_admin_menu_id('receipt');

        $this->max_width    = 281;
        $this->max_height   = 392;
	}
	private $error;

	public function index()
	{
		$this->session->unset_userdata('RECEIPT');
		$this->session->unset_userdata('transactionFile');
		$this->session->unset_userdata('mReceiptTransactionFile');
		$this->header();
	}

	public function reset()
	{
		$this->session->unset_userdata('RECEIPT');
		$this->session->unset_userdata('transactionFile');
		$this->session->unset_userdata('mReceiptTransactionFile');
	}


	public function header($mode = "insert")
	{
		// print_r($this->session->userdata('mReceiptTransactionFile'));//die();
		$this->global_libs->print_header();
		$arrJson = array();
		$namaFile = "";
		$arrTransaction = array();
		$action = $this->path.'/'.$mode;
		$docType = array('' => 'Pilih Type Transaksi',
					  '1' => '1.Penerimaan PO Supplier',
					  '2' => '2.Penerimaan Konsinyasi',
					  '3' => '3.Penerimaan Dari Site Lain',
					  '4' => '4.Penerimaan Retur Customer',
					  '5' => '5.Penerimaan Lain Lain');

		if ($this->session->userdata('mReceiptTransactionFile')!="") {
			$namaFile = $this->session->userdata('mReceiptTransactionFile');
			if (($arrJson = file_get_contents(base_url().'documents/material_receipt/'.$namaFile))!==FALSE) {
				$arrTransaction = json_decode($arrJson, true);
			}
		}
		// print_r($arrTransaction);

		$arrForm = array('document_type', 'document_origin_id', 'document_reference');
		foreach ($arrForm as $fieldName) {
			if (isset($this->error[$fieldName])) {
            	$error_message[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        } else {
	            $error_message[$fieldName] = '';
	        }
		}
		$error_message = array($error_message);
		$db_message = alert_box($this->session->flashdata('db_msg'), 'error');
		$success_msg = alert_box($this->session->flashdata('success_msg'), 'success');

		$data = array('document_type' => $docType,
					  'tblTransaction' => $arrTransaction,
					  'resetBtn' => $this->path,
					  'action' => $action,
					  'event' => $mode,
					  'error_msg' => $error_message,
					  'success_msg' => $success_msg,
					  'db_msg' => $db_message,
					  'header' => array());

		$this->parser->parse($this->template.'main', $data);
		$this->global_libs->print_footer();
	}

	public function showData($docId)
	{
		$this->reset();
		$arrDetail = array();
		$loadHeader = $this->receipt_model->getHeaderById($docId);

		if (is_array($loadHeader) && count($loadHeader) > 0) {
			$this->session->set_userdata('RECEIPT', $loadHeader);
		}
		$loadDetailTmp = $this->receipt_model->getDetailById($docId);

		if (count($loadDetailTmp) > 0 && is_array($loadDetailTmp)) {
			$measure = "";
			$HighMeasure = "";
			for ($i = 0; $i < count($loadDetailTmp); $i++) {
				$qtyTmp = isset($loadDetailTmp[$i]['arrQty'])?$loadDetailTmp[$i]['arrQty']:"";

				// unit id and qty
				if ($qtyTmp!="") {
					$arrQtyTmp = explode(",", $qtyTmp);
					if (count($arrQtyTmp) > 0 && is_array($arrQtyTmp)) {
						for ($j = 0; $j < count($arrQtyTmp); $j++){
							$unitTmp = explode(':', $arrQtyTmp[$j]);
							$loadDetailTmp[$i]['qty'][$unitTmp[0]] = $unitTmp[1];
						}
					}
					unset($loadDetailTmp[$i]['arrQty']);
					$arrQty = $loadDetailTmp[$i]['qty'];

					// measure and highestmeasure
					if (is_array($arrQty) && count($arrQty) > 0) {
						$tmp = $this->product_model->getMeasure($loadDetailTmp[$i]['product_id']);
						for ($k=0; $k < count($tmp); $k++) { 
							$measure[$tmp[$k]['unit_id']] = $tmp[$k]['measure'];
						}
						$HighMeasure = $this->product_model->getHighMeasure($loadDetailTmp[$i]['product_id']);
					}
					$loadDetailTmp[$i]['measure'] = $measure;
					$loadDetailTmp[$i]['HighestMeasure'] = $HighMeasure;
				}
			}
			/*print_r($loadDetailTmp);die();*/
			$namaFile = uniqid().'_temp.json';
			$filename = FCPATH.'documents/material_receipt/'.$namaFile;

			$fp = fopen($filename, 'w');
			if (fwrite($fp, json_encode($loadDetailTmp))!==FALSE) {
				fclose($fp);
				$sessFile = array('transactionFile' => $namaFile);
				$this->session->set_userdata('mReceiptTransactionFile', $namaFile);
				$this->session->set_flashdata('success_msg', 'Transaction loaded');
			} else {
				$this->session->set_flashdata('error_msg', 'Transaction cannot be loaded');
			}
		}

		$this->header('edit');
	}

	public function transaction($param = "")
	{
		// print_r($this->session->userdata());
		$this->global_libs->print_header();
		$warning_msg = array();
		$arrForm = array('product_id',
						'batch_number',
						'expired_date',
						'qty',
						'price');

		if ($_SERVER['REQUEST_METHOD']=="POST") {
			$post = purify($this->input->post());
			if ($param == "toDetail") {
				if (count($post) > 0) {
					$this->session->set_userdata('RECEIPT', $post);
					echo 'OK#link berhasil#'.$this->path.'/transaction';
					exit;
				}
			}
		}
		$msProduct = $this->getPagination();

		$error_message 	 = alert_box($this->session->flashdata('error_msg'), 'error');
        $success_msg = alert_box($this->session->flashdata('success_msg'), 'success');
        foreach ($arrForm as $fieldName) {
        	// set Warning Validasi Form
        	if (isset($this->error[$fieldName])) {
            	$warning_msg[$fieldName] = alert_box($this->error[$fieldName], 'error');
	        } else {
	            $warning_msg[$fieldName] = '';
	        }
        }
        $warning_msg = array($warning_msg);

		$data = array('msProduct' => $msProduct,
					  'action' => $this->path.'/actReceiptTemp',
					  'error_msg'   => $error_message,
		              'success_msg' => $success_msg,
		              'info_msg'    => $warning_msg);
		$this->parser->parse($this->template.'transaction', $data);
		$this->global_libs->print_footer();
	}

	public function transactionMirror()
	{
		$msProduct = $this->getPagination();
		$data = array('msProduct' => $msProduct);
		$this->load->view($this->template.'transactionMirror', $data);
	}

	public function freceiptDetailCustom($productId)
	{
		$batch = "0";
		$expired = "0";
		$unitQty = "";

		$data = $this->product_model->getById($productId);
		$batch = $this->product_model->cekFlag($productId, "batch_flag");
		$expired = $this->product_model->cekFlag($productId, "expired_flag");

		$unitQty = $this->product_model->getUnitQty($productId);
		if (count($unitQty) > 0) {
			$unitQty = json_encode($unitQty);

			echo $batch.'#'.$expired.'#'.$productId.'#'.$data['name'].'#'.$unitQty;
		} else {
			echo $batch.'#'.$expired.'#'.$productId.'#'.$data['name'];
		}
	}

	public function deleteDetail($id, $event = "")
	{
		$key = explode("-", $id);
		$productId = isset($key[0])?$key[0]:"";
		$unitId = isset($key[1])?$key[1]:"";

		if ($productId!="" && $unitId!="") {
			if ($this->session->userdata('mReceiptTransactionFile')!="") {
				$namaFile = $this->session->userdata('mReceiptTransactionFile');
				if (($arrJson = file_get_contents(base_url().'documents/material_receipt/'.$namaFile))!==FALSE) {
					$arrTransaction = json_decode($arrJson, true);
				}
			}

			// print_r($arrTransaction);die();
			$i = 0;
			foreach ($arrTransaction as $parentNo) {
				if (is_array($parentNo) && count($parentNo) > 0) {
					if ($parentNo['product_id']==$productId) {
						if (count($parentNo['qty']) > 1) {
							unset($arrTransaction[$i]['qty'][$unitId]);
							unset($arrTransaction[$i]['measure'][$unitId]);
						} else {
							unset($arrTransaction[$i]);
						}
					}
				}
			$i++;
			}
			
			$filename = FCPATH.'documents/material_receipt/'.$namaFile;
			$fp = fopen($filename, 'w');
			if (fwrite($fp, json_encode($arrTransaction))!==FALSE) {
				fclose($fp);
				$sessFile = array('transactionFile' => $namaFile);
				$this->session->set_userdata('mReceiptTransactionFile', $namaFile);
				$this->session->set_flashdata('success_msg', 'Transaction has been deleted');
			} else {
				$this->session->set_flashdata('error_msg', 'Transaction cannot be deleted');
			}
		}
		header("Location:".base_url().'admpage/inventory/receipt/header/'.$event);
	}

	public function actReceiptTemp()
	{
		$arrForm = array('product_id',
						'price');
		if ($_SERVER['REQUEST_METHOD']=='POST' && $this->validateForm('actReceiptTemp', $arrForm)) {
			$arrData = array();
			$arrJson = array();
			$arrDetail = array();
			$tmp = array();
			$HighMeasure = "";
			$lowMeasure = array();
			$measure = array();
			$post = purify($this->input->post());
			$namaFile = "";

			$lowMeasure = $this->product_model->getLowMeasure($post['product_id']);
			$lowMeasure['qty'] = isset($post['qty'][$lowMeasure['unit_id']])?$post['qty'][$lowMeasure['unit_id']]:"";
			if (is_array($post['qty']) && count($post['qty']) > 0) {
				$tmp = $this->product_model->getMeasure($post['product_id']);
				for ($i=0; $i < count($tmp); $i++) { 
					$measure[$tmp[$i]['unit_id']] = $tmp[$i]['measure'];
				}
				$HighMeasure = $this->product_model->getHighMeasure($post['product_id']);
			}
			$post['measure'] = $measure;
			$post['HighestMeasure'] = $HighMeasure;
			$post['lowMeasure'] = $lowMeasure;

			if ($this->session->userdata('mReceiptTransactionFile')!="") {
				$namaFile = $this->session->userdata('mReceiptTransactionFile');
				if(($arrJson = file_get_contents(base_url().'documents/material_receipt/'.$namaFile))!==FALSE) {
					$arrJson = json_decode($arrJson, true);
					$arrData = array_merge($arrJson, array($post));
				}
			} else {
				$arrData = array($post);
				$namaFile = date('YmdHms').'_temp.json';
			}
			print_r($arrData);die();
			$filename = FCPATH.'documents/material_receipt/'.$namaFile;
			$fp = fopen($filename, 'w');
			if (fwrite($fp, json_encode($arrData))!==FALSE) {
				fclose($fp);
				$sessFile = array('transactionFile' => $namaFile);
				$this->session->set_userdata('mReceiptTransactionFile', $namaFile);
				$this->session->set_flashdata('success_msg', 'Transaction has been added');
			} else {
				$this->session->set_flashdata('error_msg', 'Transaction cannot be added');
			}
			redirect($this->path_uri.'/transaction');
		}
		$this->transaction();
	}

	public function edit()
	{
		$this->insert('edit');
	}

	public function insert($event = "")
	{
		$arrForm = array('document_type', 'document_origin_id', 'document_reference');
		$namaFile = "";
		$arrDetail = array();
		$arrDetailRow = array();
		$errInsertDetail = 0;
		$arrStock = array();
		$arrJson = array();
		$arrHeader = array();
		$insertHeader = false;
		$insertStock = false;
		$insertDetail = false;
		$stockExists = false;
		$lowUnit = "";
		$docId = "";

		if ($_SERVER['REQUEST_METHOD']=='POST' && $this->validateForm('insertAll', $arrForm)) {
			try{
				$post = purify($this->input->post());
				print_r($post);die();
				$postDetail = isset($post['DETAIL'])?$post['DETAIL']:"";

				if ($this->session->userdata('mReceiptTransactionFile')!="") {
					$namaFile = $this->session->userdata('mReceiptTransactionFile');
					if(($arrJson = file_get_contents(base_url().'documents/material_receipt/'.$namaFile))!==FALSE) {
						$arrJson = json_decode($arrJson, true);
						$arrDetail = $arrJson;
					}
				}
				if ($event=='edit') {
					$docId = isset($post['document_id'])?$post['document_id']:"";
				} else {
					$docId = $this->autoInc("header");
				}
				// echo $docId;die();
				$arrHeader = array('site_id' => $this->session->userdata('RECEIPT')['site_id'],
								   'entity_id' => $this->session->userdata('ADM_SESS')['entity_id'],
								   'document_id' => $docId,
								   'date' => date('Y-m-d'),
								   'document_origin_id' => isset($post['document_origin_id'])?$post['document_origin_id']:"",
								   'document_type' => isset($post['document_type'])?$post['document_type']:"",
								   'document_reference' => isset($post['document_reference'])?$post['document_reference']:"",
								   'gross_amount' => isset($post['gross_amount'])?$post['gross_amount']:"",
								   'nett_amount' => isset($post['nett_amount'])?$post['nett_amount']:"",
								   'warehouse_id' => $this->session->userdata('ADM_SESS')['warehouse_id']);
				/*HEADER*/
				// print_r($arrDetail);die();
				if ($event=='edit') {
					$insertHeader = $this->receipt_model->updateHeader($docId, $arrHeader);
				} else {
					$insertHeader = $this->receipt_model->insertHeader($arrHeader);
				}
				if ($insertHeader) {
					if (count($arrDetail) > 0) {
						foreach ($arrDetail as $row) {
							$arrStock = array('entity_id' => $this->session->userdata('ADM_SESS')['entity_id'],
										  'warehouse_id' => $this->session->userdata('ADM_SESS')['warehouse_id'],
										  'year' => date('Y'),
										  'month' => date('m'),
										  'product_id' => isset($row['product_id'])?$row['product_id']:"",
										  'batch_number' => isset($row['batch_number'])?$row['batch_number']:"",
										  'expired_date' => isset($row['expired_date'])?$row['expired_date']:"");
							$stockExists = $this->stock_model->stockExists($arrStock);
							if ($stockExists) {
								// mode edit, clear then recreate detail 
								if ($event=='edit') {
									$exe = $this->receipt_model->deleteDetailByDocId($docId);
								}

								if (is_array($postDetail) && count($postDetail) > 0) {
									for ($i=0; $i < count($postDetail); $i++) { 
										$postDetail[$i]['document_id'] = $docId;
									}
									$insertDetail = $this->receipt_model->insertDetail($postDetail);
									if ($insertDetail===false) $errInsertDetail++;
								}
							} else {
								$errInsertDetail++;
								throw new Exception("Stock Header gagal dibuat productId ".$row['product_id']);
							}
							$arrStockDetail = array('entity_id' => $this->session->userdata('ADM_SESS')['entity_id'],
										  'warehouse_id' => $this->session->userdata('ADM_SESS')['warehouse_id'],
										  'year' => date('Y'),
										  'month' => date('m'),
										  'product_id' => isset($row['product_id'])?$row['product_id']:"",
										  'batch_number' => isset($row['batch_number'])?$row['batch_number']:"",
										  'expired_date' => isset($row['expired_date'])?$row['expired_date']:"",
										  'document_type' => '1',
										  'document_id' => $docId);
							$arrStockDetailVar = array('date' => date('Y-m-d'),
													   'product_status' => '1',
													   'stock_entry' => isset($row['stockEntry'])?$row['stockEntry']:"");
							$stockDetailExists = $this->stock_model->stockDetailExists($arrStockDetail, $arrStockDetailVar);
							if ($stockDetailExists) {
								if ($event=='edit') {
									$exe = $this->stock_model->deleteStockDetail($arrStockDetail);

								}
							}
						}
						if ($errInsertDetail > 0) {
							$delAll = $this->receipt_model->delete($docId);
							throw new Exception("Detail gagal dibuat");
						} else {
							$this->session->unset_userdata('RECEIPT');
							$this->session->unset_userdata('transactionFile');
							if ($this->session->userdata('mReceiptTransactionFile')!="") {
								$namaFile = $this->session->userdata('mReceiptTransactionFile');
								$filename = FCPATH.'documents/material_receipt/'.$namaFile;
								if (file_exists($filename)) {
									unlink($filename);
								}
							}
							$this->session->unset_userdata('mReceiptTransactionFile');

							$this->session->set_flashdata('success_msg', 'Data Berhasil dibuat');
						}
					}
				} else { //header exception
					throw new Exception("Insert ke Tabel Header Gagal");
				}
			}catch(Exception $e){
				$delAll = $this->receipt_model->delete($docId);
				$this->session->set_flashdata('db_msg', $e);
			}
		}
		$this->header();
	}

	private function autoInc($table = "")
	{
		$num = 0;
		$ret = "";
		$last = 0;
		if ($table=="header") {
			$sql = $this->product_model->maxDocId();
			if (count($sql) > 0) {
				if (is_null($sql['maks'])) {
					$num = sprintf("%04d", 1);		
					$ret = 'RG'.date('Ym').$num;
				} else {
					$last = substr($sql['maks'], -4);
					$num = ltrim($last, '0') + 1;
					$num = sprintf("%04d", $num);
					$ret = 'RG'.date('Ym').$num;
				}
			}
		}
		return $ret;
	}

	function cekDetail()
	{
		if ($this->session->userdata('mReceiptTransactionFile')!="") {
					$namaFile = $this->session->userdata('mReceiptTransactionFile');
					if(($arrJson = file_get_contents(base_url().'documents/material_receipt/'.$namaFile))!==FALSE) {
						$arrJson = json_decode($arrJson, true);
						$arrDetail = array_merge($arrJson, array($post));
					}
				}
				print_r($arrDetail);die();
	}

	private function validateForm($form = "", $arrForm = array())
	{
		$post = purify($this->input->post());

        if (!auth_access_validation(adm_sess_usergroupid(),$this->ctrl)) {
            $this->error['warning'] = 'You can\'t manage this content.<br/>';
        }

        if ($form=="actReceiptTemp") {
        	if ($post['product_id']!="") {
        		$batch = $this->product_model->cekFlag($post['product_id'], "batch_flag");
				$expired = $this->product_model->cekFlag($post['product_id'], "expired_flag");

				if ($batch > 0) {
					if ($post['batch_number']=='') {
						$this->error['batch_number'] = 'Batch Number Cannot be empty';
					}
				}
				if ($expired > 0) {
					if ($post['expired_date']=='') {
						$this->error['expired_date'] = 'Expired Date Cannot be empty';
					}
				}
	        	if (count($arrForm) > 0) {
	        		foreach ($arrForm as $fieldName) {
			            if ($post[$fieldName]=='') {
			            	$this->error[$fieldName] = $fieldName.' Cannot be empty';
			            } else {
			                if ($fieldName!='expired_date') {
			                    if (!is_numeric($post[$fieldName])) {
			                        $this->error[$fieldName] = $fieldName.' Must in Numeric';
			                    }
			                }
			            }
			        }
	        	}
        	} else {
        		$this->error['product_id'] = 'Product ID Cannot be empty';
        	}
        } elseif ($form=="insertAll") {
        	if (count($arrForm) > 0) {
        		foreach ($arrForm as $fieldName) {
        			if ($post[$fieldName]=='') {
        				$this->error[$fieldName] = $fieldName.' Cannot be empty';
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
	    $page_url = $config['base_url'] = base_url().'admpage/inventory/receipt/transactionMirror/';
	    $config['uri_segment'] = 5;

	    $config['per_page'] = 10;
	    $config['num_links'] = 5;
	    if(empty($page_number)) $page_number = 1;
	    $offset = ($page_number-1) * $config['per_page'];

	    $config['use_page_numbers'] = TRUE;
	    $data["product"] = $this->product_model->getAll($searchBy, $searchVal, $config['per_page'],$offset);
	    $config['total_rows'] = $this->product_model->getTotal($searchBy, $searchVal);

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