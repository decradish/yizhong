<?php require_once(dirname(__FILE__).'/'.'../public/header_admin.php');?>

<a href="/admin/" class="btn btn-primary">返回</a>
<p></p>

<form action="" method="post" class="edit_form">
<fieldset>
	<legend>首页</legend>
	<table class="site_table">
		<tr>
			<td>
				<label class="control-label" for="title">二维码: </label>
			</td>
			<td class="td_last">
				<input class="form-control" type="text" name="qr_code" id="qr_code" placeholder="请输入二维码图片地址" value="<?php echo @$qr_code;?>">
			</td>
			<td class="td_vt" rowspan="4">
				<label class="control-label" for="gallery_img_0">轮播图: </label>
			</td>
			<td rowspan="4">
				<?php
				$count = 0;
				foreach ($gallery_img as $key => $value):?>
					<input class="form-control" type="text" name="gallery_img_<?php echo $count;?>" id="gallery_img_<?php echo $count;?>" placeholder="请输入轮播图链接" value="<?php echo @$value;?>"><p></p>
				<?php
					$count ++;
				endforeach;?>
			</td>
		</tr>
		<tr>
			<td>
				<label class="control-label" for="download_ios">iOS下载链接: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="download_ios" id="download_ios" placeholder="请输入iOS下载链接" value="<?php echo @$download_ios;?>">
			</td>
		</tr>
		<tr>
			<td>
				<label class="control-label" for="download_android">Android下载链接: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="download_android" id="download_android" placeholder="请输入Android下载链接" value="<?php echo @$download_android;?>">
			</td>
		</tr>
		<tr>
			<td class="td_vt">
				<label class="control-label" for="banner">首页底部大图: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="banner" id="banner" placeholder="请输入图片地址" value="<?php echo @$banner;?>"><p></p>
				<input class="form-control" type="text" name="banner_link" id="banner_link" placeholder="请输入链接地址" value="<?php echo @$banner_link;?>">
			</td>
		</tr>
		<tr>
			<td class="td_vt">
				<label class="control-label" for="update_mining_data">挖矿数据: </label>
			</td>
			<td>
				<a id="update_mining_data" name="update_mining_data" class="btn btn-success" href="javascript:void(0);">更新</a>
			</td>
			<td></td>
			<td></td>
		</tr>
	</table>
</fieldset>

<fieldset>
	<legend>联系我们</legend>
	<table class="site_table">
		<tr>
			<td>
				<label class="control-label" for="title">微信公众号: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="weixin" id="weixin" placeholder="请输入微信公众号" value="<?php echo @$weixin;?>">
			</td>
			<td>
				<label class="control-label" for="title">微博链接: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="weibo" id="weibo" placeholder="请输入微博链接" value="<?php echo @$weibo;?>">
			</td>
		</tr>
		<tr>
			<td>
				<label class="control-label" for="title">QQ群: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="qq" id="qq" placeholder="请输入QQ群" value="<?php echo @$qq;?>">
			</td>
			<td>
				<label class="control-label" for="title">邮箱: </label>
			</td>
			<td>
				<input class="form-control" type="text" name="email" id="email" placeholder="请输入邮箱" value="<?php echo @$email;?>">
			</td>
		</tr>
	</table>
</fieldset>

	<div class="btn_wrapper">
		<input class="btn btn-success btn-lg" type="submit" value="提交">
		<input class="btn btn-lg" type="reset" value="重置" onclick="confirm('您真的要重置吗？');">
	</div><!-- /.btn_wrapper -->
</form>

<!-- <script src="//cdn.ckeditor.com/4.4.6/full/ckeditor.js"></script> -->
<script type="text/javascript" src="/public/js/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
<?php if(!empty($msg)):?>
alert("<?php echo $msg;?>");
<?php endif;?>

$(function(){
	$("#update_mining_data").click(function(){
		$.ajax({
			url: '/admin/update_mining_data',
			type: 'post',
			data: {},
			success: function(data){
				console.log(data);
				alert(data.msg);
			},
			error: function(data){
				// console.log(data);
			}
		});
	});
});
</script>

<?php require_once(dirname(__FILE__).'/'.'../public/footer_admin.php');?>