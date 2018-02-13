<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>


<div class="box box-primary">
	<div class="box-body box-profile">

		<img src="<?= $model->getImage()->getUrl('128x128') ?>" class="profile-user-img img-responsive img-circle" alt="<?= $model->title ?>"/>

		<h3 class="profile-username text-center"><?= $model->fullFio ?></h3>

		<p class="text-muted text-center"><?= $model->fullCompanyName ?></p>

		<p class="text-muted text-center"><?= implode(' • ', $model->workingsAsTitleArray)?></p>

		<ul class="list-group list-group-unbordered">

			<li class="list-group-item"><b>Размещенных заказов</b> <a class="pull-right"><?= $model->order_placed_counter ?></a>
			</li>
			<li class="list-group-item"><b>Актуальных заказов</b> <a class="pull-right"><?= $model->order_actual_counter ?></a>
			</li>
			<li class="list-group-item"><b>Подписчиков</b> <a class="pull-right"><?= $model->follower_counter ?></a>
			</li>
			<li class="list-group-item"><b>Подписан на</b> <a class="pull-right"><?= $model->following_counter ?></a>
			</li>
			<li class="list-group-item"><b>Выполнено заказов</b> <a class="pull-right"><?= $model->executed_orders ?></a>
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
		      Url::remember();
		      if ($foll ==  0) {
		          echo '<a href="' . Url::toRoute(['/company/foll/follow', 'user_id' => $model->user_id, 'follow' => true]) . '" class="btn btn-primary btn-block"><b>Подписаться</b></a>';          
		      } else {
		          echo '<a href="' . Url::toRoute(['/company/foll/follow', 'user_id' => $model->user_id, 'follow' => false]) . '" class="btn btn-warning btn-block"><b>Прекратить подписку</b></a>';
		      }
		  } else {
		      echo Html::a('Редактировать',['/profile/default/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-info btn-block']); 
		  }
		?>
		
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->

