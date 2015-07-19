<?php
$controller = $this->uri->segment(1);
$method = $this->uri->segment(2);

$bHome = false;
if(!$controller){
	$bHome = true;
}elseif($controller == 'index' && !$method){
	$bHome = true;
}elseif($controller == 'index' && $method == 'index'){
	$bHome = true;
}
$account = !empty($_COOKIE['username']) ? $_COOKIE['username'] : null;
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>亿众</title>
	<base href="<?php echo base_url() ?>">
	<link rel="stylesheet" href="public/css/style.css" media="all">

	<script type="text/javascript" src="public/js/html5.js"></script>
	<script type="text/javascript" src="public/js/jquery-1.11.1.min.js"></script>

</head>
<body>
	<header>
		<a href="/" class="logo" title="亿众">亿众</a>

		<div class="nav">
			<a class="<?php if($bHome):?>current<?php endif;?>" href="/">首页</a> |
			<a class="<?php if($controller == 'product'):?>current<?php endif;?>" href="product">产品中心</a> |
			<a class="<?php if($controller == 'about'):?>current<?php endif;?>" href="about">关于我们</a> |
			<a class="<?php if($controller == 'parental'):?>current<?php endif;?>" href="parental">家长监控</a> |
			<a class="<?php if($controller == 'payment'):?>current<?php endif;?>" href="payment">在线充值</a> |
			<a class="<?php if($controller == 'user'):?>current<?php endif;?>" href="user"><?php if($account):?>您好,<?php echo $account;else:?>登录注册<?php endif;?></a>
		</div><!-- /.nav -->

		<!-- <a href="/" class="cs">客服</a> -->
	</header>