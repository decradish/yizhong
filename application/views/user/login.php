<?php require_once(dirname(__FILE__).'/'.'../public/header.php');?>


	<div class="banner banner_user"></div><!-- /.banner -->

	<div class="main">
		<div class="left">
			<div class="crumbs">
				<a href="/">首页</a> > 用户注册
			</div><!-- /.crumbs -->

			<div class="core user">
				<form action="user/login" method="post" onsubmit="return oLogin.check();">
					<table id="login_tb" class="member_tb">
						<thead>
							<tr>
								<th colspan="3">亿众通行证登录</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>用户名：</td>
								<td>
									<input type="text" name="username" id="username" placeholder="请输入用户名" value="<?php echo @$username;?>">
								</td>
								<td class="msg_td"><?php echo @$error['username'];?></td>
							</tr>
							<tr>
								<td>密码：</td>
								<td>
									<input type="password" name="password" id="password" placeholder="请输入密码" value="<?php echo @$password;?>">
								</td>
								<td class="msg_td"><?php echo @$error['password'];?></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td></td>
								<td>
									<input type="submit" value="登录">
									<input type="button" value="注册" class="btn" onclick="javascript:window.location.href='user/member'">
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</form>
				<!-- 请在充值的备注中填写您的游戏账号<br /> -->
			</div><!-- /.core -->
		</div><!-- /.left -->

<script type="text/javascript">
var oLogin = {
	oTb: $('#login_tb'),
	oInput: {},
	init: function(){
		var self = this
		self.oInput = self.oTb.find('input:text, input:password')
		this.bind()
	},
	bind: function(){
		var self = this
	},
	msg: function(obj, msg, msg_type){
		var sMsg = msg ? msg : obj.attr('placeholder'),
			oMsgTd = obj.parent('td').nextAll('td.msg_td'),
			sClass = msg_type ? msg_type : 'red',
			sHtml = msg == '' ? '' : '<span class="'+sClass+'">'+sMsg+'</span>'

		oMsgTd.html(sHtml)
	},
	check: function(){
		var self = this,
			error = 0

		self.oTb.find('td.msg_td').html('')
		self.oInput.each(function(i){
			var oThis = $(this),
				sThis = oThis.val(),
				sId   = oThis.attr('id')

			if($.trim(sThis) == ''){
				error ++
				self.msg(oThis)
			}
		})

		if(error == 0){
			return true
		}else{
			return false
		}
	}
}
oLogin.init()
</script>
<?php require_once(dirname(__FILE__).'/'.'../public/right.php');?>
<?php require_once(dirname(__FILE__).'/'.'../public/footer.php');?>