<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

    public function not_login(){
        $data = array();

        $this->load->view('admin/not_login', $data);
    }

    public function fBrowLogout(){
        unset($_SESSION['uid']);
        unset($_SESSION['nick']);
        unset($_SESSION['account']);
        unset($_SESSION['aos_uid']);
        unset($_SESSION['dev_skip']);
        setcookie('suid','',time()-3600);
        // $_COOKIE['sso'] = null;
        setcookie("sso","", time() - 3600);
        setcookie("passport_login","", time() - 3600,'/','.amap.com');

        echo 1;
    }

    public function fBrowLogin(){
        $data = array();
        $iLogStatu = 0;
        if(isset($_COOKIE['passport_login'])){
            // import('ORG.Util.Cookie');
            $COOKIE_INFO = $_COOKIE['passport_login'];
            $info = explode(',',base64_decode($COOKIE_INFO));
            if(count($info)==5)
            {
                $auth= base64_encode(md5($info[0].$info[1].$info[2].$info[3].COOKIE_CONST));
                if($auth ==$info[4]){
                    //如果成功登陆
                    $_SESSION['aos_uid'] = $info[0];
                    $_SESSION['account'] = $info[1];
                    $_SESSION['aos_session'] = $info[2];
                    $iLogStatu = 1;
                }
            }
        }

        if(!$iLogStatu){//未登录
            setcookie("passport_login",'',time()-3600,'/','amap.com');
            $data['logged']   = false;
            $data['account']  = null;
            $data['redirect'] = false;
        }else{//已登录
            $data['logged']  = true;
            $data['account'] = $_SESSION['account'];

            //如果url中有external_url字段，表示已跳转，不用跳转
            if(strpos($_SERVER['HTTP_REFERER'], @$_GET['external_url']) !== false){
                $data['redirect'] = false;
            }
        }

        header('Content-type: text/json');
        echo json_encode($data);
    }
}


/* End of file api.php */
/* Location: ./application/controllers/api.php */