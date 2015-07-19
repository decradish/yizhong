<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {

	/**
	 * Sms Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		header('Content-Type: application/json');
		$data = array();

		$phone = $this->input->post('phone');
		$code = $_SESSION['code'] = rand(1000,9999);

		$apikey = SMSKEY;
		$tpl_id = 830521;
		$tpl_value = urlencode("#code#=$code");
		$rel = sock_post(SMS_M_URL, "apikey=$apikey&mobile=$phone&tpl_id=$tpl_id&tpl_value=$tpl_value");
		die($rel);
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */