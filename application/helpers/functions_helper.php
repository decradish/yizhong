<?php
$CI =& get_instance(); // Get the global CI object

function fOb2Arr($ob=''){
    foreach ($ob as $key => $value) {
        $ob[$key] = (array)$value;
    }
    return $ob;
}

if ( ! function_exists('css_url'))
{
    function css_url($uri = '')
    {
        $CI =& get_instance();
        $css_string = "<link rel='stylesheet' type='text/css' href='".$CI->config->base_url("/public".$uri)."' media='all'>";
        return $css_string;
    }
}
//---------------------------------
if ( ! function_exists('js_url'))
{
    function javascript_url($uri = '')
    {
        $CI =& get_instance();
        $javascript_string = "<script type='text/javascript' src='".base_url("/public".$uri)."'></script>";
        return $javascript_string;
    }
}

/**
* url 为服务的url地址
* query 为请求串
*/
function sock_post($url,$query){
    $data = "";
    $info=parse_url($url);
    $fp=fsockopen($info["host"],80,$errno,$errstr,30);
    if(!$fp){
        return $data;
    }
    $head="POST ".$info['path']." HTTP/1.0\r\n";
    $head.="Host: ".$info['host']."\r\n";
    $head.="Referer: http://".$info['host'].$info['path']."\r\n";
    $head.="Content-type: application/x-www-form-urlencoded\r\n";
    $head.="Content-Length: ".strlen(trim($query))."\r\n";
    $head.="\r\n";
    $head.=trim($query);
    $write=fputs($fp,$head);
    $header = "";
    while ($str = trim(fgets($fp,4096))) {
        $header.=$str;
    }
    while (!feof($fp)) {
        $data .= fgets($fp,4096);
    }
    return $data;
}

/** 
 * IsMail函数:检测是否为正确的邮件格式 
 * 返回值:是正确的邮件格式返回邮件,不是返回false 
 */ 
function IsMail($Argv){ 
    // $RegExp='/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
    $RegExp='/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i';
    return preg_match($RegExp,$Argv)?$Argv:false;
} 

/** 
 * IsMobile函数:检测参数的值是否为正确的中国手机号码格式 
 * 返回值:是正确的手机号码返回手机号码,不是返回false 
 */ 
function IsMobile($Argv){ 
    $RegExp='/^(?:13|14|15|17|18)[0-9]{9}$/'; 
    return preg_match($RegExp,$Argv)?$Argv:false; 
}

/**
 * 获取访客IP
 * @param bool $isHeader 是否从请求头中判断，请求头可被伪造IP，所以不推荐使用，默认为false
 * @return string
 */
function getIP($isHeader=false)
{
    if($isHeader)
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && check_ip($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && check_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (isset($_SERVER['REMOTE_ADDR']) && check_ip($_SERVER['REMOTE_ADDR']))
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    else
    {
        return 'unknown';
    }
}

/**
 * 判断IP地址是否符合IPv4的格式
 * @param string $str
 * @return boolean
 */
function check_ip($str)
{
    return preg_match('/""A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))"".){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))""Z/',$str)>0;
}

/**
 * 说明：检测IP是否在IP段内
 * 作者：upall,http://upall.cn/
 * 日期：13:50 2011年5月28日 星期六
 * 用法：$ipCheck = new ipCheck('192.168.1.1-254');
 *       echo (TRUE === $ipCheck ->check('192.168.1.45')) ? 'PASS' : $ipCheck->msg;
 *       或者：
 *       $ipCheck = new ipCheck('192.0.0.1-192.254.254.254');
 *       echo (FALSE !== $ipCheck ->check('192.168.10.45')) ? 'PASS' : $ipCheck->msg;
 *       或者：
 *       $ipCheck = new ipCheck('192.168.1.1/24');
 *       echo (FALSE !== $ipCheck ->check('192.168.10.45')) ? 'PASS' : $ipCheck->msg;
 */
class ipCheck {
    public $ipRangeStr = '10.0.0.1/8';
    public $msg = '';
    
    function __construct($ipRangeStr){
        !empty($ipRangeStr) ? $this->ipRangeStr = $ipRangeStr : '';
    }
    
    function check($ip = '') {
        empty($ip) && $ip = $this->getClientIp();
        
        # 判断检测类型
        if (FALSE !== strpos($this->ipRangeStr,'-')){
            $type = 'size'; // 简单比大小：10.0.0.1-254 OR 10.0.0.1-10.0.0.254
        }else if(FALSE !== strpos($this->ipRangeStr,'/')){
            $type = 'mask'; // 掩码比大小：10.0.0.1/24
        }else{
            // $this->msg = '错误的IP范围值';
            $this->msg = 'Wrong range of IP values';
            return FALSE;
        }
        # 分析IP范围
        if ('size' === $type){
            $ipRangeStr = explode('-',$this->ipRangeStr);
            $ipAllowStart = $ipRangeStr[0];
            $ipAllowEnd = $ipRangeStr[1];
            if (FALSE === strpos($ipAllowEnd,'.')){ # 10.0.0.254 OR 254
                $ipAllowElmArray = explode('.',$ipAllowStart);
                $ipAllowEnd = $ipAllowElmArray[0] . '.' . 
                                    $ipAllowElmArray[1] . '.' . 
                                    $ipAllowElmArray[2] . '.' . 
                                    $ipAllowEnd;
            }
        }else if ('mask' === $type){
            $ipRangeStr = explode('/',$this->ipRangeStr);
            $ipRangeIP = $ipRangeStr[0];
            # 获取掩码中最后一位非零数的值
            $ipRangeMask = (int)$ipRangeStr[1];
            $maskElmNumber = floor($ipRangeMask/8); # 保留IP前几段
            $maskElmLastLen = $ipRangeMask % 8; # 255.255.here.0
            $maskElmLast = str_repeat(1,8-$maskElmLastLen);
            $maskElmLast = bindec($maskElmLast); # 掩码中IP末段最大值(十进制)
            
            // 获取IP段开始、结束值
            $ipRangeIPElmArray = explode('.',$ipRangeIP);
            if (0 == $maskElmNumber){
                $ipAllowStart = '0.0.0.0';
                $ipAllowEnd = $maskElmLast . '.254.254.254';
            }else if (1 == $maskElmNumber){
                $ipAllowStart = $ipRangeIPElmArray[0] . '.' . '0.0.0';
                $ipAllowEnd = $ipRangeIPElmArray[0] . '.' . $maskElmLast . '.254.254';
            }else if (2 == $maskElmNumber){
                $ipAllowStart = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . '0.0';
                $ipAllowEnd = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . $maskElmLast . '.254';
            }else if (3 == $maskElmNumber){
                $ipAllowStart = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . $ipRangeIPElmArray[2] . '.' . '0';
                $ipAllowEnd = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . $ipRangeIPElmArray[2] . '.' . $maskElmLast;
            }else if (4 == $maskElmNumber){
                $ipAllowEnd = $ipAllowStart = $ipRangeIP;
            }else{
                // $this->msg = '错误的IP段数据';
                $this->msg = 'Wrong IP';
                return $this->msg;
            }
        }else{
            // $this->msg = '错误的IP段类型';
            $this->msg = 'Wrong IP type';
            return $this->msg;
        }
        // 检测IP
        $ipAllowStart = $this->getDecIp($ipAllowStart);
        $ipAllowEnd = $this->getDecIp($ipAllowEnd);
        $ip = $this->getDecIp($ip);
        if (!empty($ip)){
            if ($ip <= $ipAllowEnd && $ip >= $ipAllowStart){
                // $this->msg = 'IP检测通过';
                $this->msg = 'PI test pass';
                return TRUE;
            }else{
                // $this->msg = '此为被限制IP';
                $this->msg = 'This is the refused IP';
                return FALSE;
            }
        }else{
            // FALSE === ($this->msg) && $this->msg == '没有提供待检测IP'; // getClentIp() 是否返回false
            FALSE === ($this->msg) && $this->msg == 'There is no IP to test'; // getClentIp() 是否返回false
            return $this->msg; // 没有获取到客户端IP，返回
        }
    }

    // 10进制IP
    function getDecIp($ip){
        $ip = explode(".", $ip); 
        return $ip[0]*255*255*255+$ip[1]*255*255+$ip[2]*255+$ip[3];
    }

    // 获取客户端IP
    function getClientIp(){
        if(isset($_SERVER['REMOTE_ADDR'])){
            return $_SERVER['REMOTE_ADDR'];
        }else{
            // $this->msg = '不能获取客户端IP';
            $this->msg = "Can't get IP of the client";
            return FALSE;
        }
    }
}

function getRealIp(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function countChinese($str){
    preg_match_all('/./us', $str, $match);
    return count($match[0]);
}

function verifyEncrypt($str=false,$key=null,$oDec=false){
    if(!$str){
        $str = IP_ENCRYPT_PREFIX.$_SERVER["REMOTE_ADDR"];
        // $str = C('IP_ENCRYPT_PREFIX').'100.100.100.101';
    }
    if(!$key){
        $key = IP_ENCRYPT_KEY;
    }

    $enc = openssl_encrypt($str, 'bf-ecb', $key, true);
    // echo(bin2hex($enc).PHP_EOL);
    if($oDec){
        $str = hex2bin($str);
        // $dec = openssl_decrypt($str, 'bf-ecb', $key, true);
        $dec = openssl_decrypt($str, 'bf-ecb', $key, true);
        // return bin2hex($dec);    
        return $dec;
    }else{
        return bin2hex($enc);
    }
}

function fgc_post($url='', $post = null){
     $context = array();

     if (is_array($post)){
         ksort($post);

         $context['http'] = array
         (   
            'timeout' => 60,
            'method'  => 'POST',
            'content' => http_build_query($post, '', '&'),
            'header'  => 'Content-type: application/x-www-form-urlencoded'
            //, Content-type: application/json
         );
     }
     $stream = stream_context_create($context);

     return file_get_contents($url, false, $stream);
}

function fGetLink($segm='',$value='',$aOrigSegm=array(),$site_url=''){
    $url = '';
    if(!empty($segm)){
        $aOrigSegm[$segm] = $value;
        foreach ($aOrigSegm as $key => $single) {
            $url .= $single.'/';
        }
    }
    return $site_url.$url;
}