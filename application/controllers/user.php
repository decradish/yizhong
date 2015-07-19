<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Payment Page for this controller.
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
		$this->load->helper('cookie');
	}

	public function index(){
		$data = array();

		$this->load->view('user/login', $data);
	}

	public function member(){
		$data = array();
		$data['error'] = array();
		$dbData = array();

		if(!empty($_POST)){
			$username = $data['username'] = $this->input->post('username');
			$password = $data['password'] = $this->input->post('password');
			$realname = $data['realname'] = $this->input->post('realname');
			$id_no    = $data['id_no']    = $this->input->post('id_no');
			$phone    = $data['phone']    = $this->input->post('phone');
			$code     = $data['code']     = $this->input->post('code');

			$rel = $this->Ori_model->mGetBy('username', $username);
			if(!empty($rel)){
				$data['error']['username'] = '<span class="red">此用户名已被使用</span>';
			}
			$rel = $this->Ori_model->mGetBy('id_no', $id_no);
			if(!empty($rel)){
				$data['error']['id_no'] = '<span class="red">此号码已被使用</span>';
			}
			$rel = $this->Ori_model->mGetBy('phone', $phone);
			if(!empty($rel)){
				$data['error']['phone'] = '<span class="red">此用户名已被使用</span>';
			}

			if(empty($_SESSION['code']) || $code != $_SESSION['code']){
				$data['error']['code'] = '<span class="red">验证码错误</span>';
			}

			if(!empty($data['error'])){
				$this->load->view('user/member', $data);
			}else{
				$dbData = $data;
				$dbData['ip'] = getRealIp();
				unset($dbData['code']);
				unset($dbData['error']);


				$rel = $this->Ori_model->mAdd($dbData);
				$this->set_cookie($username);
				redirect('');
			}
		}else{
			$this->load->view('user/member', $data);
		}
	}

	public function login(){
		$data = array();
		$data['error'] = array();

		if(!empty($_POST)){
			$username = $data['username'] = $this->input->post('username');
			$password = $data['password'] = $this->input->post('password');

			if(empty($username)){
				$data['error']['user'] = '<span class="red">账号不能为空</span>';
			}
			if(empty($password)){
				$data['error']['password'] = '<span class="red">密码不能为空</span>';
			}

			if(empty($data['error'])){
				$rel = $this->Ori_model->mGetBy('username', $username);
				$user = $rel[0];
				if($user['password'] != $password){
					$data['error']['password'] = '<span class="red">密码错误</span>';
				}
			}

			if(!empty($data['error'])){
				$this->load->view('user/login', $data);
			}else{
				$this->set_cookie($username);
				redirect('');
			}

		}else{
			$this->load->view('user/login', $data);
		}
	}

	public function set_cookie($username, $auot_login=true){
		$time = $auot_login ? 6*30*24*60*60 : null;
		set_cookie("username", $username, $time);//设置6个月的cookie

	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */