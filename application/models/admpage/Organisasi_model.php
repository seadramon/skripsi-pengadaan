<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Organisasi_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

    protected $table = "organisasi";

	function insert($data)
    {
        $result = 0;
        if (is_array($data) && count($data) > 0) {
        	$this->db->set('id_organisasi', 'UUID()', FALSE);
            if ($this->db->insert($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function update($id = "", $data = array())
    {
        $result = 0;
        if ($id!="" && count($data) > 0) {
            $this->db->where('id_organisasi', $id);
            if ($this->db->update($this->table, $data)) {
                $result = 1;
            }
        }
        return $result;
    }

    function delete($id)
    {
        $result = null;

        $this->db->where('id_organisasi', $id);
        if ($this->db->delete($this->table)) {
            $result = true;
        }

        return $result;
    }

    function getTotal($name = null)
    {
        $total = 0;
        
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        $this->db->select('COUNT(id_organisasi) as total');
        $query = $this->db->get($this->table)->row_array();

        $total = isset($query['total'])?$query['total']:0;
        return $total;
    }

    function getAll($name = null, $per_pg = null, $limit = null)
    {
        if ($name != null) $this->db->like('LOWER(nama)', strtolower($name));
        if ($per_pg !== null && $limit !== null) $this->db->limit($per_pg, $limit);

        $query = $this->db->get($this->table);

        return $query;
    }

    function getById($id)
    {
        $this->db->where('id_organisasi', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        return $query;
    }

    function getByConfirmcode($code)
    {
        $result = null;

        $this->db->where('confirmation_code', $code);
        $query = $this->db->get($this->table);

        return $query->row_array();
    }

    function status($id, $status)
    {
    	$result = null;

    	$this->db->where('id_organisasi', $id);
    	if ($status=='publish') {
    		$data['status'] = 'unpublish';
    	} else {
    		$data['status'] = 'publish';
    	}
    	
    	if ($this->db->update($this->table, $data)) {
            $result = 1;
        }

        return $result;
    }

    // FRONT
    function insertUserAdminorg($data, $confcode, $id_organisasi)
    {
        $result = false;
        // print_r($data);die();
        // Konfirmasi Kode
        $arrConfirm = array('confirmation_code' => '',
                        'confirmed_at' => date('Y-m-d H:i:s'));
        $this->db->where('confirmation_code', $confcode);
        $confirm = $this->db->update($this->table, $arrConfirm);

        if ($this->db->insert('user', $data)) {
            $child = array('id_user' => $data['id_user'],
                        "id_organisasi" => $id_organisasi);
            if ($this->db->insert($data['role'], $child)) {
                $arrEmail = array('subject' => 'Informasi Organisasi '.str_replace("admin", "", $data['nama']),
                    'message' => sprintf("Selamat, <br> Organisasi anda telah berhasil dikonfirmasi, Berikut user akses untuk admin organisasi<br>
                                        email : %s <br>
                                        password : bantuin", $data['email']),
                    'email' => $data['email']);
                if (!$this->sendmail($arrEmail)) {
                    log_message('error', date('Y-m-d H:i:s').' - Email konfirmasi organisasi ke '.$data['email'].' gagal dikirim');
                }

                $result = true;
            }
        }
        return $result;
    }

    function insertUser($data)
    {
        $jmlUser = count($data['user']);
        $child = array();
        $mail = array();

        $arrConfirm = array('confirmation_code' => '',
                        'confirmed_at' => date('Y-m-d H:i:s'));
        $this->db->where('confirmation_code', $data['confirmation_code']);
        $confirm = $this->db->update($this->table, $arrConfirm);

        if ($confirm) {
            $mail = array('subject' => 'Informasi Organisasi Bantuin',
                    'message' => "Selamat, <br> Organisasi anda telah berhasil dikonfirmasi");
            if (!$this->sendmail($mail)) {
                log_message('error', date('Y-m-d H:i:s').' - Email konfirmasi organisasi ke '.$value['email'].' gagal dikirim');
            }

            if (count($data['user']) > 0 && is_array($data['user'])) {
                foreach ($data['user'] as $value) {
                    $value['id_user'] = uuid();
                    $value['group_id'] = 3;
                    $value['password'] = md5('bantuin');
                    $value['created'] = date('Y-m-d');

                    $mail = array('subject' => 'Informasi User Bantuin',
                        'email' => $value['email'],
                        'message' => sprintf('Selamat User anda telah terdaftar. Berikut aksesnya <br>
                         Username : %s <br>
                         Password: bantuin', $value['email']));
                    if (!$this->sendmail($mail)) {
                        log_message('error', date('Y-m-d H:i:s').' - Email ke tujuan '.$value['email'].' gagal dikirim');
                    }

                    if ($this->db->insert('user', $value)) {
                        $child = array('id_user' => $value['id_user'],
                                    'id_organisasi' => $data['id_organisasi']);
                        $this->db->insert($value['role'], $child);
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    function sendmail($post)
    {
        if (is_array($post) && count($post) > 0) {
            $this->load->library('email');
 
            $subject = isset($post['subject'])?$post['subject']:""; 
            $message = isset($post['message'])?$post['message']:"";
             
            $email = $this->email
                    ->from('percival5695@gmail.com', 'Bantuin')
                    ->to($post['email'].', margi.landshark@gmail.com', 'Ini Usernya, user2')
                    ->subject($subject)
                    ->message($message);
             
            if (!$email->send()) {
                // echo $email->ErrorInfo();
                return false;
            } else {
                return true;
            }
        }
    }
}



?>