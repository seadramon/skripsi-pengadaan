<?php 
/**
* 
*/
class Bimura extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('generator_model');
	}

	public function index()
	{
		// dd(dirname($_SERVER["SCRIPT_FILENAME"])."/uploads/");
		$postId = 0;
		$this->db->select('PartNumber, Description, Mfr, Price, Units, ShippingWeight, UNSPSC, CountryOfOrigin, TechSpec, Picture');
		$this->db->from('wp_grainger');
		$this->db->limit(10);
		$grainger = $this->db->get()->result_array();

		foreach ($grainger as $row) {
			$nextId = $this->generator_model->post_nextId();

			$arrdata = array('post_author' => 1,
				'post_date' => date('Y-m-d H:i:s'),
				'post_date_gmt' => date('Y-m-d H:i:s'),
				'post_content' => $row['Description'],
				'post_title' => $row['PartNumber'],
				'post_excerpt' => '',
				'post_status' => 'publish',
				'comment_status' => 'open',
				'ping_status' => 'open',
				'post_password' => '',
				'post_name' => slug($row['PartNumber'], '-'),
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => date('Y-m-d H:i:s'),
				'post_modified_gmt' => date('Y-m-d H:i:s'),
				'post_content_filtered' => '',
				'post_parent' => 0,
				'guid' => 'http://bimura.dev/?p='.$nextId,
				'menu_order' => 0,
				'post_type' => 'post',
				'post_mime_type' => '',
				'comment_count' => 0
			);
			$postId = $this->generator_model->insert_post($arrdata);

			// Picture 
			$pict = explode('|', $row['Picture']);
			foreach ($pict as $rowPict) {
				if ($rowPict!="") {
					$pictSlug = slug($rowPict, '-');
					$pictExist = $this->generator_model->pictExist($pictSlug);

					if ($pictExist < 1) {
						$downloadPict = $this->downloadPict($rowPict);

						$arrPict = array(
							'post_author' => 1,
							'post_date' => date('Y-m-d H:i:s'),
							'post_date_gmt' => date('Y-m-d H:i:s'),
							'post_content' => '',
							'post_title' => $pictSlug,
							'post_excerpt' => '',
							'post_status' => 'inherit',
							'comment_status' => 'open',
							'ping_status' => 'closed',
							'post_password' => '',
							'post_name' => $pictSlug,
							'to_ping' => '',
							'pinged' => '',
							'post_modified' => date('Y-m-d H:i:s'),
							'post_modified_gmt' => date('Y-m-d H:i:s'),
							'post_content_filtered' => '',
							'post_parent' => $postId,
							'guid' => 'http://bimura.dev/wp-content/uploads/'.date('Y/m').'/'.$downloadPict,
							'menu_order' => 0,
							'post_type' => 'attachment',
							'post_mime_type' => 'image/jpeg',
							'comment_count' => 0
						);
						$pictId = $this->generator_model->insert_post($arrPict);		
					}
				}	
			}

			$arrmetaField = array('Mfr', 'Price', 'Units', 'Shipping Weight', 'UNSPSC', 'Country Of Origin', 'Tech Spec');
			foreach ($arrmetaField as $metaRow) {
				$arrmeta = array();

				if ($metaRow=='Tech Spec') {
					$arrTech = 	explode('|', $row[str_replace(' ', '', $metaRow)]);

					foreach ($arrTech as $rowTech) {
						$arrmeta = array('post_id' => $postId,
							'meta_key' => '_'.slug($metaRow, '_'),
							'meta_value' => $rowTech
						);	

						$postmeta = $this->generator_model->insert_meta($arrmeta);
					}
				} else {
					$arrmeta = array('post_id' => $postId,
						'meta_key' => '_'.slug($metaRow, '_'),
						'meta_value' => $row[str_replace(' ', '', $metaRow)]
					);

					$postmeta = $this->generator_model->insert_meta($arrmeta);
				}
			}
		}
		
		$data = $this->generator_model->wp_posttemp();
		dd($data);
	}

	private function downloadPict($name)
	{
		$url = 'https://static.grainger.com/rp/s/is/image/Grainger/'.$name;
		$localpath = dirname($_SERVER["SCRIPT_FILENAME"]).'/uploads/';

		if (!file_exists($localpath.date('Y'))) {
		    mkdir($localpath.date('Y'), 0777, true);
		}

		if (!file_exists($localpath.date('Y').'/'.date('m'))) {
		    mkdir($localpath.date('Y').'/'.date('m'), 0777, true);
		}
		$localpath = dirname($_SERVER["SCRIPT_FILENAME"]).'/uploads/'.date('Y/m').'/';

		$filename = trim(slug($name, '-')).'.jpg';
		$put = file_put_contents($localpath.$filename, fopen($url, 'r'));

		return $filename;
	}

}