<?php require_once(dirname(__FILE__).'/'.'../public/header_admin.php');?>

<a href="/admin/" class="btn btn-primary">返回</a>

<form action="" method="post">
<table class="edit_table">
	<tr>
		<?php $id = $this->uri->segment(3);?>
		<th colspan="2"><?php if($id):?>编辑<?php else:?>添加<?php endif;?>文章</th>
	</tr>
	<tr>
		<td>
			<label class="control-label" for="title">Title: </label>
		</td>
		<td>
			<input class="form-control" type="text" name="title" id="title" placeholder="Please input title" value="<?php echo @$title;?>">
			<?php if(!empty($msg_title) && $msg_title):?>
			<span class="text-danger">Please input title</span>
			<?php endif;?>
		</td>
	</tr>
	<tr>
		<td class="td_vt">
			<label class="control-label" for="content">Content: </label>
		</td>
		<td>
			<textarea class="form-control ckeditor" name="content" id="content" cols="30" rows="10" placeholder="Please input content"><?php echo @$content;?></textarea>
			<?php if(!empty($msg_content) && $msg_content):?>
			<span class="text-danger">Please input content</span>
			<?php endif;?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<label for="raider">
				<input type="checkbox" name="raider" id="raider" value="0" <?php if(isset($type) && $type == "0"):?>checked="checked"<?php endif;?> />
				攻略
			</label>
		</td>
	</tr>
	<tr id="parent_tr" class="<?php if(!isset($type) || $type != "0"):?>hide<?php endif;?>">
		<td>
			<label class="control-label" for="">Parent: </label>
		</td>
		<td>
			<select name="block_parent" class="form-control block_parent">
				<option value="0">Please select parent</option>
				<?php foreach ($raider_post as $key => $value):?>
					<?php if($value['id'] != $this->uri->segment(3)):?>
					<option <?php if(isset($parent) && $parent == $value['id']):?>selected="selected"<?php endif;?> value="<?php echo $value['id'];?>"><?php echo $value['title'];?></option>
					<?php endif;?>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
	<tr id="block_tr" class="<?php if(!isset($type) || $type != "0"):?>hide<?php endif;?>">
		<td class="td_vt">
			<label class="control-label" for="title">Block: </label>
		</td>
		<td id="block_td">
			<?php if(@$type == 0 && !empty($blocks)):?>
				<?php $blocks = json_decode($blocks, true);?>
				<?php foreach ($blocks as $key => $value):?>
				<fieldset>
					<legend>
						<input type="text" class="form-control block_title" name="" id="" placeholder="Block title" value="<?php echo $value['title'];?>">
					</legend>

					<input type="button" class="btn btn-danger delete_fieldset" title="Delete fieldset" value="X">

					<?php foreach ($value['blocks'] as $key_blocks => $value_blocks):?>
					<div class="block">
						<input type="button" class="btn btn-danger btn-sm delete_block" value="X" title="Delete block">
						<textarea class="form-control block_content" name="" id="" rows="5" placeholder="Block content"><?php echo $value_blocks['content'];?></textarea>

						<?php 
						if(isset($value_blocks['img'])):
							foreach ($value_blocks['img'] as $key_img => $value_img):?>
							<input type="text" class="form-control block_img" name="" id="" placeholder="Block image" value="<?php echo $value_img;?>">
							<input type="button" class="btn btn-danger delete_img" value="x" title="Delete this image">
							<?php endforeach;
						else:?>
							<input type="text" class="form-control block_img" name="" id="" placeholder="Block image" value="">
							<input type="button" class="btn btn-danger delete_img" value="x" title="Delete this image">
						<?php endif;?>

						<input type="button" class="btn btn-success add_img" value="Add image" title="Add image">
					</div><!-- /.block -->
					<?php endforeach;?>

					<div class="clear"></div>

					<div class="block_btn">
						<input type="button" class="btn btn-info add_block" value="Add block">
					</div><!-- /.block -->
				</fieldset>
				<?php endforeach;?>
			<?php endif;?>

			<input type="button" id="add_fieldset" class="btn btn-primary add_fieldset" value="Add fieldset">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input class="btn btn-primary btn-lg" type="submit" value="提交">
			<input class="btn btn-lg" type="reset" value="重置" onclick="confirm('您真的要重置吗？');">
		</td>
	</tr>
</table><!-- /.edit_table -->
</form>

<div class="none">
	<fieldset>
		<legend>
			<input type="text" class="form-control block_title" name="" id="" placeholder="Block title">
		</legend>

		<input type="button" class="btn btn-danger delete_fieldset" title="Delete fieldset" value="X">

		<div class="block">
			<input type="button" class="btn btn-danger btn-sm delete_block" value="X" title="Delete block">
			<textarea class="form-control block_content" name="" id="" rows="5" placeholder="Block content"></textarea>

			<input type="text" class="form-control block_img" name="" id="" placeholder="Block image">
			<input type="button" class="btn btn-danger delete_img" value="x" title="Delete this image">

			<input type="button" class="btn btn-success add_img" value="Add image" title="Add image">
		</div><!-- /.block -->

		<div class="clear"></div>

		<div class="block_btn">
			<input type="button" class="btn btn-info add_block" value="Add block">
		</div><!-- /.block -->
	</fieldset>
</div><!-- /.none -->

<!-- <script src="//cdn.ckeditor.com/4.4.6/full/ckeditor.js"></script> -->
<script type="text/javascript" src="/public/js/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
<?php if(!empty($msg)):?>
alert("<?php echo $msg;?>");
<?php endif;?>

var oBlockTd        = $('#block_td'),
	oFieldset       = oBlockTd.find('fieldset'),
	oBlocks         = oBlockTd.find('div.block'),
	oFieldsetClone  = $('div.none fieldset').clone(),
	oBlockClone     = oFieldsetClone.find('div.block:first').clone(),
	oImgClone       = oBlockClone.find('input.block_img:last').clone(),
	oDeleteImgClone = oBlockClone.find('input.delete_img:last').clone();

function fSortName(){
	$('#block_td fieldset').each(function(i){
		var oThis = $(this);
		oThis
			.find('input.block_title').attr("name", "block_title[]").end()
			.find('div.block').each(function(j){
				var oThisBlock = $(this);
				oThisBlock
					.find('textarea.block_content').attr("name", "block_content["+i+"][]").end()
					.find('input.block_img').each(function(k){
						var oThisImg = $(this);
						oThisImg.attr("name", "block_img["+i+"]["+j+"][]");
					});
			});
	});
}

$(function(){
	fSortName();

	$('#raider').change(function(){
		var oThis     = $(this),
			bRaider   = oThis.prop('checked'),
			oParentTr = $('#parent_tr'),
			oBlockTr  = $('#block_tr');
		if(bRaider){
			oParentTr.removeClass('hide');
			oBlockTr.removeClass('hide');
		}else{
			oParentTr.addClass('hide');
			oBlockTr.addClass('hide');
		}
	});

	oBlockTd
		.delegate('input.delete_fieldset', 'click', function(){
			var oThis = $(this);
			if(!confirm('您确定要删除吗？')){return}
			oThis.parent().remove();

			fSortName();
		})
		.delegate('input.delete_block', 'click', function(){
			var oThis = $(this);
			if(!confirm('您确定要删除吗？')){return}
			oThis.parent().remove();

			fSortName();
		})
		.delegate('input.delete_img', 'click', function(){
			var oThis = $(this);
			if(!confirm('您确定要删除此图片吗？')){return}
			oThis
				.prev().remove().end()
				.remove();

			fSortName();
		})
		.delegate('input.add_img', 'click', function(){
			var oThis = $(this);
			oThis.before(oImgClone);
			oThis.before(oDeleteImgClone);
			oImgClone = oBlockClone.find('input.block_img:last').clone()
			oDeleteImgClone = oBlockClone.find('input.delete_img:last').clone();

			fSortName();
		})
		.delegate('.add_block', 'click', function(){
			var oThis = $(this);
			oThis.parent().prev('.clear').before(oBlockClone);
			oBlockClone = oFieldsetClone.find('div.block:first').clone();

			fSortName();
		})
		.delegate('#add_fieldset', 'click', function(){
			var oThis = $(this);
			oThis.before(oFieldsetClone);
			oFieldsetClone = $('div.none fieldset').clone();

			fSortName();
		});
});
</script>

<?php require_once(dirname(__FILE__).'/'.'../public/footer_admin.php');?>