<?php 


use yii\helpers\Url;

?>

<div class="order-item">
	<div class="row">
		<div class="col-md-1">
			<img src="<?= $model->profile->getImage()->getUrl('70x70') ?>" class="img-circle" alt=""/>
		</div>
    	<div class="col-md-8">
    		<h2><a href="<?= Url::toRoute(['/order/default/view', 'id' => $model->id]) ?>"><?= $model->title ?></a></h2>
    	</div>
    	<div class="col-md-3">
    		<h4>
        		<i class="fa fa-fw fa-money"></i>
        		<?= Yii::$app->formatter->asCurrency($model->budget, 'RUB') ?>
    		</h4>
    	</div>
    	<div class="col-md-12">
    		<i class="fa fa-fw fa-commenting"></i> <?= $model->response_counter ?> откликов
    		<i class="fa fa-fw fa-bullseye"></i> <?= $model->view_counter ?> просмотров
    		<i class="fa fa-fw fa-clock-o"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    		
    	</div>
    </div>
</div>
<hr>