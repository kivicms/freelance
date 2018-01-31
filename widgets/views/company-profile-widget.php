<?php
?>


<div class="box box-primary">
	<div class="box-body box-profile">
		<!-- <img class="profile-user-img img-responsive img-circle"
			src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->

		<img src="<?= $model->profile->getImage()->getUrl('128x128') ?>" class="profile-user-img img-responsive img-circle" alt="<?= $model->profile->title ?>"/>

		<h3 class="profile-username text-center"><?= $model->profile->fullFio ?></h3>

		<p class="text-muted text-center"><?= $model->profile->fullCompanyName ?></p>

		<ul class="list-group list-group-unbordered">
			<li class="list-group-item"><b>Размещенных заказов</b> <a class="pull-right"><?= $model->profile->order_placed_counter ?></a>
			</li>
			<li class="list-group-item"><b>Актуальных заказов</b> <a class="pull-right"><?= $model->profile->order_actual_counter ?></a>
			</li>
			<li class="list-group-item"><b>Подписчиков</b> <a class="pull-right"><?= $model->profile->follower_counter ?></a>
			</li>
			<li class="list-group-item"><b>Подписан на</b> <a class="pull-right"><?= $model->profile->following_counter ?></a>
			</li>
		</ul>
		<?php 
          if ($model->user_id !== Yii::$app->user->id) {
              $foll = Yii::$app->db->createCommand('
                select 
                    count(*)
                from
                    follower
                where
                    user_id=:user_id AND follower_id=:follower_id
              ',[
                  ':user_id' => $model->user_id,
                  ':follower_id' => Yii::$app->user->id
              ])->queryScalar();
		      
		      if ($foll ==  0) {
		          echo '<a href="#" class="btn btn-primary btn-block"><b>Подписаться</b></a>';          
		      }
		  }
		?>
		
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->

<!-- About Me Box -->
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">О нас</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">		
		<strong><i class="fa fa-map-marker margin-r-5"></i> Местоположение</strong>
		<p class="text-muted"><?= $model->profile->address_fact ?></p>
		<hr>
		
		<strong><i class="fa  fa-check-square-o margin-r-5"></i> Верификация</strong>
		<p class="text-muted"><?= $model->profile->is_verified ? 'Пользователь верифицирован' : 'Непроверенный пользователь' ?></p>
		<hr>

		<strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

		<p>
			<span class="label label-danger">UI Design</span> <span
				class="label label-success">Coding</span> <span
				class="label label-info">Javascript</span> <span
				class="label label-warning">PHP</span> <span
				class="label label-primary">Node.js</span>
		</p>

		<hr>

		<strong><i class="fa fa-file-text-o margin-r-5"></i> Описание</strong>

		<p><?= $model->profile->description ?></p>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->