<?php 

?>

<!-- About Me Box -->
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">О нас</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">		
		<strong><i class="fa fa-map-marker margin-r-5"></i> Местоположение</strong>
		<p class="text-muted"><?= $model->address_fact ?></p>
		<hr>
		
		<strong><i class="fa  fa-check-square-o margin-r-5"></i> Верификация</strong>
		<p class="text-muted"><?= $model->is_verified ? 'Пользователь верифицирован' : 'Непроверенный пользователь' ?></p>
		<hr>
		
		<strong><i class="fa  fa-sitemap margin-r-5"></i> Веб сайт</strong>
		<p class="text-muted"><?= $model->www  ?></p>
		<hr>
		
		<strong><i class="fa  fa-phone margin-r-5"></i> Телефон</strong>
		<p class="text-muted"><?= $model->phone ?></p>
		<hr>

		<!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

		<p>
			<span class="label label-danger">UI Design</span> <span
				class="label label-success">Coding</span> <span
				class="label label-info">Javascript</span> <span
				class="label label-warning">PHP</span> <span
				class="label label-primary">Node.js</span>
		</p>

		<hr> -->

		<strong><i class="fa fa-file-text-o margin-r-5"></i> Описание</strong>

		<p><?= $model->description ?></p>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->