<?php require_once(dirname(__FILE__).'/'.'../public/header.php');?>


	<div class="banner banner_payment"></div><!-- /.banner -->

	<div class="main">
		<div class="left">
			<div class="crumbs">
				<a href="/">首页</a> > <a href="payment">充值</a>
			</div><!-- /.crumbs -->

			<div class="core payment">
				<table class="payment_tb">
					<thead>
						<tr>
							<th colspan="2">亿众充值</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>充值账号：</td>
							<td>
								<input type="text" name="username" id="username" value="<?php echo @$_COOKIE['username'];?>">
							</td>
						</tr>
						<tr>
							<td>选择游戏：</td>
							<td class="icon_td">
								<img class="current" src="public/media/3nations/3nations-icon.png" alt="">
								<img src="public/media/fish/fish-260icon.png" alt="">
							</td>
						</tr>
						<tr>
							<td>充值点券数额：</td>
							<td>
								<ul class="denomination">
									<li class="current">100</li>
									<li>50</li>
									<li>30</li>
								</ul><!-- /.denomination -->
							</td>
						</tr>
						<tr>
							<td>应付金额：</td>
							<td class="money_td"><strong id="money">100</strong> 元</td>
						</tr>
						<tr>
							<td class="vertical_top">支付方式：</td>
							<td>
								<div class="banks">
									<label class="pay_type_0">
										<input type="radio" name="pay_type" id="" checked="checked">
										<span>支付宝</span>
									</label>
									<label class="pay_type_1">
										<input type="radio" name="pay_type" id="">
										<span>中国农业银行</span>
									</label>
									<label class="pay_type_2">
										<input type="radio" name="pay_type" id="">
										<span>中国工商银行</span>
									</label>
									
									<label class="pay_type_3">
										<input type="radio" name="pay_type" id="">
										<span>中国建设银行</span>
									</label>
									<label class="pay_type_4">
										<input type="radio" name="pay_type" id="">
										<span>中国邮政储蓄银行</span>
									</label>
									<label class="pay_type_5">
										<input type="radio" name="pay_type" id="">
										<span>中国银行</span>
									</label>
									
									<label class="pay_type_6">
										<input type="radio" name="pay_type" id="">
										<span>招商银行</span>
									</label>
									<label class="pay_type_7">
										<input type="radio" name="pay_type" id="">
										<span>交通银行</span>
									</label>
									<label class="pay_type_8">
										<input type="radio" name="pay_type" id="">
										<span>浦发银行</span>
									</label>
									
									<label class="pay_type_9">
										<input type="radio" name="pay_type" id="">
										<span>中国光大银行</span>
									</label>
									<label class="pay_type_10">
										<input type="radio" name="pay_type" id="">
										<span>中信银行</span>
									</label>
									<label class="pay_type_11">
										<input type="radio" name="pay_type" id="">
										<span>平安银行</span>
									</label>
									
									<label class="pay_type_12">
										<input type="radio" name="pay_type" id="">
										<span>中国民生银行</span>
									</label>
									<label class="pay_type_13">
										<input type="radio" name="pay_type" id="">
										<span>华夏银行</span>
									</label>
									<label class="pay_type_14">
										<input type="radio" name="pay_type" id="">
										<span>广发银行</span>
									</label>
									<label class="pay_type_15">
										<input type="radio" name="pay_type" id="">
										<span>兴业银行</span>
									</label>
								</div><!-- /.banks -->
							</td>
						</tr>
						<tr>
							<td>手机号：</td>
							<td>
								<input type="text" name="phone" id="phone" placeholder="请输入您的手机号">
								<span></span>
							</td>
						</tr>
						<tr>
							<td>验证码：</td>
							<td class="verify_td">
								<input type="text" name="code" id="code" placeholder="请输入验证码">
								<input type="button" value="获取验证码" id="sms_btn" class="btn">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<a class="payment_a" href="http://www.alipay.com">立即支付</a>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- 请在充值的备注中填写您的游戏账号<br /> -->
			</div><!-- /.core -->
		</div><!-- /.left -->

<script type="text/javascript">
function isPhoneNo(aPhone){
	var bValidate = RegExp(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/).test(aPhone);
	if (bValidate) {
		return true;
	}
	else
		return false;
}

function msg(obj, msg, msg_type){
	var sMsg = msg ? msg : obj.attr('placeholder'),
		sClass = msg_type ? msg_type : 'red',
		sHtml = msg == '' ? '' : '<span class="'+sClass+'">'+sMsg+'</span>'

	obj.next().html(sHtml)
}

var oSmsBtn = $('#sms_btn')
	oPhone = $('#phone'),
	iPhone = oPhone.val(),
	oCode = $("#code"),
	checkPhone = function(){
		var oPhone = $('#phone'),
			iPhone = oPhone.val()

		if(iPhone == ''){
			msg(oPhone)
			return false
		}else if(!isPhoneNo(iPhone)){
			msg(oPhone, '电话号码格式错误')
			return false
		}else{
			return true
		}
	}

oSmsBtn.click(function(event) {
	if(!checkPhone()){return false}

	var oPhone = $('#phone'),
		iPhone = oPhone.val(),
		oCode = $("#code")

	msg(oPhone, '')

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
				msg(oPhone, '验证码已发送', 'blue')
			}else{
				msg(oPhone, '发送失败，请重试')
			}
		},
		error: function(data){
			// console.log('error: ', data)
		}
	})
});
</script>

<?php require_once(dirname(__FILE__).'/'.'../public/right.php');?>
<?php require_once(dirname(__FILE__).'/'.'../public/footer.php');?>