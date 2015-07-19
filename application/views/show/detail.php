<?php require_once(dirname(__FILE__).'/'.'../public/header.php');?>

<div class="main">
	<div class="card">
		<h2><a href="/lists/">‹‹ 最新资讯</a></h2>

		<article>
			<h1><?php echo $post['title'];?></h1>
			<span class="time"><?php echo date('Y年n月j日',strtotime($post['create_time']));?></span>

			<div class="content">
				<?php echo $post['content'];?>
			</div><!-- /.content -->
		</article>
	</div><!-- /.card -->
</div><!-- /.main -->

<?php require_once(dirname(__FILE__).'/'.'../public/footer.php');?>