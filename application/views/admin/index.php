<?php require_once(dirname(__FILE__).'/'.'../public/header_admin.php');?>

<a class="btn btn-success" href="/admin/edit/">Add</a>
<a class="btn btn-info" href="/admin/site/">Edit Site</a>
<p></p>

<table class="table table-striped list">
	<tr>
		<th>ID</th>
		<th>Link</th>
		<th><a href="/admin/index/<?php if($this->uri->segment(3) === false || $this->uri->segment(3) == 1):?>0<?php else:?>1<?php endif;?>">Type</a></th>
		<th class="center_td">Time</th>
		<th>Action</th>
	</tr>

	<?php foreach ($list as $key => $value):?>
	<?php $id = $value['id'];?>
	<tr>
		<td><?php echo $id;?></td>
		<td class="td_left title_td">
			<a target="_blank" href="/raiders/index/<?php echo $id;?>"><?php echo $value['title'];?></a>
		</td>
		<td>
			<?php if($value['type'] == '0'):?><span class="btn btn-primary btn-xs">攻略</span><?php else:?><span class="btn btn-warning btn-xs">资讯</span><?php endif;?>
		</td>
		<td class="center_td"><?php echo $value['create_time'];?></td>
		<td>
			<a class="btn btn-info btn-xs" href="/admin/edit/<?php echo $id;?>">Edit</a>
			<a class="btn btn-danger btn-xs" href="/admin/delete/<?php echo $id;?>" onclick="return confirm('您确定要删除此文章吗？');">Delete</a>
		</td>
	</tr>
	<?php endforeach;?>
</table>

<?php require_once(dirname(__FILE__).'/'.'../public/footer_admin.php');?>