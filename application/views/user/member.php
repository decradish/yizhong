<?php require_once(dirname(__FILE__).'/'.'../public/header.php');?>


	<div class="banner banner_user"></div><!-- /.banner -->

	<div class="main">
		<div class="left">
			<div class="crumbs">
				<a href="/">首页</a> > 用户注册
			</div><!-- /.crumbs -->

			<div class="core user">
				<form action="" method="post" onsubmit="return oReg.check();">
					<table id="member_tb" class="member_tb">
						<thead>
							<tr>
								<th colspan="3">亿众通行证注册</th>
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
								<td class="msg_td"></td>
							</tr>
							<tr>
								<td>重复密码：</td>
								<td>
									<input type="password" name="repassword" id="repassword" placeholder="请重复输入密码" value="<?php echo @$password;?>">
								</td>
								<td class="msg_td"></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td class="info_td" colspan="3">请填写下方身份信息</td>
							</tr>
							<tr>
								<td>真实姓名：</td>
								<td>
									<input type="text" name="realname" id="realname" placeholder="请输入您的真实姓名" value="<?php echo @$realname;?>">
								</td>
								<td class="msg_td"></td>
							</tr>
							<tr>
								<td>身份证号码：</td>
								<td>
									<input type="text" name="id_no" id="id_no" maxlength="18" placeholder="请输入身份证号码" value="<?php echo @$id_no;?>">
								</td>
								<td class="msg_td"><?php echo @$error['id_no'];?></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td>请输入手机号：</td>
								<td>
									<input type="text" name="phone" id="phone" maxlength="11" placeholder="请输入手机号" value="<?php echo @$phone;?>">
								</td>
								<td class="msg_td"><?php echo @$error['phone'];?></td>
							</tr>
							<tr>
								<td>验证码：</td>
								<td class="verify_td">
									<input type="text" name="code" id="code" maxlength="4" placeholder="请输入验证码">
									<input type="button" id="send_sms_btn" value="获取验证码">
								</td>
								<td class="msg_td"><?php echo @$error['code'];?></td>
							</tr>
						</tbody>
						<tbody>
							<tr>
								<td></td>
								<td>
									<input type="checkbox" name="accept" id="accept" checked="checked" value="yes">
									<label for="accept">阅读并接受<a href="#" target="_blank">《亿众时代用户协议》</a></label>
								</td>
								<td class="msg_td"></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="submit" value="注册">
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
function isCardNo(card)  
{  
	// 身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X  
	var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;  
	if(reg.test(card) === false){    
		return  false;  
	}else{
		return true
	}
}
function isPhoneNo(aPhone){
	var bValidate = RegExp(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/).test(aPhone);
	if (bValidate) {
		return true;
	}
	else
		return false;
}
var oReg = {
	oTb: $('#member_tb'),
	oInput: {},
	oSendSms: $('#send_sms_btn'),
	init: function(){
		var self = this
		self.oInput = self.oTb.find('input:text, input:password')
		this.bind()
	},
	bind: function(){
		var self = this
		self.oSendSms.click(function(event) {
			self.sendSms()
		});
	},
	msg: function(obj, msg, msg_type){
		var sMsg = msg ? msg : obj.attr('placeholder'),
			oMsgTd = obj.parent('td').nextAll('td.msg_td'),
			sClass = msg_type ? msg_type : 'red',
			sHtml = msg == '' ? '' : '<span class="'+sClass+'">'+sMsg+'</span>'

		oMsgTd.html(sHtml)
	},
	sendSms: function(){

		var self = this,
			oPhone = $('#phone'),
			iPhone = oPhone.val(),
			oCode = $("#code")

		if(!self.checkPhone()){return false}

		self.msg(oCode, '')

		$.ajax({
			url: '/sms',
			data: {
				phone: iPhone
			},
			type: 'post',
			dataType: 'json',
			success: function(data){
				// console.log(data)

				if(data.code == 0){
					self.msg(oCode, '验证码已发送', 'blue')
				}else{
					self.msg(oCode, '发送失败，请重试')
				}
			},
			error: function(data){
				// console.log('error: ', data)
			}
		})
	},
	checkPhone: function(){
		var self = this,
			oPhone = $('#phone'),
			iPhone = oPhone.val()

		if(iPhone == ''){
			self.msg(oPhone)
			return false
		}else if(!isPhoneNo(iPhone)){
			self.msg(oPhone, '电话号码格式错误')
			return false
		}else{
			return true
		}
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
			}else{
				switch(sId){
					case 'repassword':
						if(sThis != $('#password').val()){
							error ++
							self.msg(oThis, '两次密码输入不一致')
						}
						break;
					case 'id_no':
						if(!isCardNo(sThis)){
							error ++
							self.msg(oThis, '身份证号格式错误')
						}
						break;
					case 'phone':
						if(!isPhoneNo(sThis)){
							error ++
							self.msg(oThis, '电话号码格式错误')
						}
						break;
					default:
				}
			}
		})
		
		var oAccept = $('#accept'),
			bAccept = oAccept.prop('checked')
		if(!bAccept){
			error ++
			self.msg(oAccept, '请同意此协议')
		}

		if(error == 0){
			return true
		}else{
			return false
		}
	}
}
oReg.init()
</script>
<?php require_once(dirname(__FILE__).'/'.'../public/right.php');?>
<?php require_once(dirname(__FILE__).'/'.'../public/footer.php');?>