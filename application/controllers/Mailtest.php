<?php
/**
* 
*/
class Mailtest extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	/*public function index()
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'margi.landshark@gmail.com',
			'smtp_pass' => 'dmgdmg5795',
			'smtp_crypto' => 'ssl',
			'newline' => "\r\n",
			'mailtype'  => 'html');

		$this->load->library('email', $config);
		// $this->email->set_newline();
		$this->email->initialize();

		$this->email->from('margi.landshark@gmail.com', 'Damar Margi');
		$this->email->to('percival5695@gmail.com');
		$this->email->subject('Ini email test');
		$this->email->message('It s Working great!');

		if ($this->email->send()) {
			echo "Your email was sent";
		} else {
			show_error($this->email->print_debugger());
		}
	}*/

	public function index()
	{
		$this->load->library('email');
 
		$subject = 'Test Mail Id : BAntuin'; 
		$message = 'great work, Ini dari mailtest 2';

		// print_r($this->email->)
		 
		$email = $this->email
				->from('margi.landshark@gmail.com', 'Admin Bantuin')
		 		->to('percival5695@gmail.com')
		 		->subject($subject)
		 		->message($message);
		 
		if (!$email->send()) {
			echo $email->ErrorInfo;
		} else {
			// exit();
			// return true;
			echo "berhasil";
			// redirect(base_url());
		}
	}

	public function result($name)
	{
		// echo $name;
		$this->index();
		echo "lanjut";
	}
}
?>