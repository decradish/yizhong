<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/admin
	 *	- or -  
	 * 		http://example.com/index.php/admin/index
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
		if(isLogin() && ($_SESSION['account'] == 'decradish' || $_SESSION['account'] == 'gxdtaojin')){
			//success
		}else{
			//没权限
			redirect('api/not_login');
		}
	}

	public function index($type=1){
		$data = array();

		$rel = $this->Gxd_model->mGetBy('type', $type);
		$data['list'] = $rel;

		$this->load->view('admin/index', $data);
	}

	public function edit($id=null){
		$data = array();
		$data['raider_post'] = $raider_post = $this->Gxd_model->mGetBy('type', 0);

		if(!empty($id) && empty($_POST)){
			$id = (int)$id;
			$rel = $this->Gxd_model->mGet($id);
			
			$data = array_merge($rel[0], $data);

			$this->load->view('admin/edit', $data);
			return;
		}

		if(!empty($_POST)){
			$error = 0;
			
			$data['title']         = $title         = $this->input->post('title');
			$data['content']       = $content       = $this->input->post('content');
			$data['parent']        = $parent        = $this->input->post('block_parent');
			$raider                = $this->input->post('raider');
			$data['raider']        = $raider === false ? '1' : $raider;
			$data['block_title']   = $block_title   = $this->input->post('block_title');
			$data['block_content'] = $block_content = $this->input->post('block_content');
			$data['block_img']     = $block_img     = $this->input->post('block_img');

			$block = array();
			if(isset($block_title) && !empty($block_title)){
				foreach ($block_title as $key => $value) {
					$block[$key] = array();	
					$block[$key]['title'] = $value;

					$content = array();
					foreach ($block_content[$key] as $key_con => $value_con) {
						$content[$key_con] = array();
						$content[$key_con]['content'] = $value_con;

						if(isset($block_img[$key])){
							foreach ($block_img[$key] as $key_img => $value_img) {
								$content[$key_img]['img'] = array_filter($value_img);
							}
						}
					}
					$block[$key]['blocks'] = $content;
				}
			}

			// header("Content-type: application/json");
			// die(json_encode($block));


			if(empty($title)){
				$error ++;
				$data['msg_title'] = true;
			}
			if(empty($content) && $raider !== "0"){
				$error ++;
				$data['msg_content'] = true;
			}

			if($error > 0){
				$this->load->view('admin/edit', $data);
				return;
			}else{
				$aDb            = array();
				$aDb['title']   = $data['title'];
				$aDb['content'] = $data['content'];
				if($raider === "0"){
					$aDb['parent'] = $parent;
					$aDb['type']   = $raider;
					$aDb['blocks'] = json_encode($block);
				}

				if(!empty($id)){
					$id = (int)$id;

					$rel = $this->Gxd_model->mUpdate($id, $aDb);

					if($rel){
						$data['msg'] = '更新成功 :)';
					}else{
						$data['msg'] = '更新失败，请重试 :(';
					}

					$aDb['raider_post'] = $raider_post;

					$this->load->view('admin/edit', $aDb);
					return;
				}

				$rel = $this->Gxd_model->mAdd($aDb);

				if($rel){
					$data['msg'] = '添加成功 :)';
					redirect('admin/index');
					// $this->load->view('admin/edit', $data);
				}else{
					$data['msg'] = '添加失败，请重试 :(';

					$aDb['raider_post'] = $raider_post;
					$this->load->view('admin/edit', $aDb);
				}
				return;
			}
		}

		$this->load->view('admin/edit', $data);
	}

	public function delete($id=null){
		if(!empty($id)){
			$id = (int)$id;
			$rel = $this->Gxd_model->mDelete($id);

			if($rel){
				$data['msg'] = "删除成功 :)";
				redirect('admin');
			}
		}
	}

	public function site(){
		$data = array();

		if(!empty($_POST)){
			$data['qr_code']          = $this->input->post('qr_code');
			$data['download_ios']     = $this->input->post('download_ios');
			$data['download_android'] = $this->input->post('download_android');
			$data['banner']           = $this->input->post('banner');
			$data['banner_link']      = $this->input->post('banner_link');

			$data['gallery_img'][] = $this->input->post('gallery_img_0');
			$data['gallery_img'][] = $this->input->post('gallery_img_1');
			$data['gallery_img'][] = $this->input->post('gallery_img_2');
			$data['gallery_img'][] = $this->input->post('gallery_img_3');
			$data['gallery_img'][] = $this->input->post('gallery_img_4');

			$data['weixin'] = $this->input->post('weixin');
			$data['weibo']  = $this->input->post('weibo');
			$data['qq']     = $this->input->post('qq');
			$data['email']  = $this->input->post('email');

			foreach ($data as $key => $value) {
				// if(empty($value)){continue;}

				$rel = $this->Gxd_model->mGetBy('option', $key, 'gxd_option');
				$aDb = array();
				if(count($rel) > 0){
					$option = $rel[0];
					if($key == 'gallery_img'){
						foreach ($data['gallery_img'] as $key_gallery => $value_gallery) {
							$aDb['value_'.$key_gallery] = $value_gallery;
						}
						$data['gallery_img'] = $aDb;
						$rel1 = $this->Gxd_model->mUpdate($option['id'], $aDb, 'gxd_option');
					}else{
						$aDb['value_0'] = $value;
						$rel1 = $this->Gxd_model->mUpdate($option['id'], $aDb, 'gxd_option');
					}
				}else{
					if($key == 'gallery_img'){
						$aDb['option'] = 'gallery_img';
						foreach ($data['gallery_img'] as $key_gallery => $value_gallery) {
							$aDb['value_'.$key_gallery] = $value_gallery;
						}
						$rel1 = $this->Gxd_model->mAdd($aDb, 'gxd_option');
					}else{
						$aDb['option'] = $key;
						$aDb['value_0'] = $value;
						$rel1 = $this->Gxd_model->mAdd($aDb, 'gxd_option');
					}
				}
			}

			$this->load->view('admin/site', $data);
			return;
		}else{
			$rel = $this->Gxd_model->mGetAllReal('gxd_option');
			// $data['gallery_img'] = array();
			foreach ($rel as $key => $value) {
				if($value['option'] === 'gallery_img'){
					// $data[$value['option']] = $value;
					for ($i=0; $i < 5; $i++) { 
						$data[$value['option']][] = $value['value_'.$i];
					}
				}else{
					$data[$value['option']] = $value['value_0'];
				}
			}

			$this->load->view('admin/site', $data);
		}
	}

	public function update_mining_data(){
		$now_str = date(('Y-m-d H:i:s'), time());
		$aMsg = array();
		$aDb = array();
		$aDb['option'] = 'mining';
		$aDb['long_varchar'] = @file_get_contents(MINING_URL);
		if($aDb['long_varchar']){
			$mining = $aDb['long_varchar'];
			$aDb['create_time'] = $now_str;
			$rel = $this->Gxd_model->mUpdateBy('option', 'mining', $aDb, 'gxd_option');
			if($rel){
				$aMsg['error'] = 0;
				$aMsg['status'] = 'Success';
				$aMsg['msg'] = '更新成功 :)';

				header('Content-Type: application/json');
				die(json_encode($aMsg));
			}else{
				$aMsg['error'] = 2;
				$aMsg['status'] = 'Update fail';
				$aMsg['msg'] = '更新失败，请重试 :(';

				header('Content-Type: application/json');
				die(json_encode($aMsg));
			}
		}else{
			$aMsg['error'] = 1;
			$aMsg['status'] = 'Get data fail';
			$aMsg['msg'] = '数据获取失败，请重试 :(';

			header('Content-Type: application/json');
			die(json_encode($aMsg));
		}
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */