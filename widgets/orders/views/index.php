<?php 
use yii\helpers\Url;

/* @var Order $models */
?>



<div class="orders-widget">
	<ul class="products-list product-list-in-box">
		<?php foreach ($models as $model) : ?>		
		<li class="item">
			<div class="product-img">
				<img src="<?= $model->getImage()->getUrl('70x70') ?>" alt="<?= $model->title ?>">
			</div>
			<div class="product-info">
				<a href="<?= Url::toRoute(['/order/default/view', 'id' => $model->id])?>" class="product-title"><?= $model->title ?>
					<span class="label label-warning pull-right"><?= Yii::$app->formatter->asCurrency($model->budget, 'RUB') ?></span>
				</a> 
				<span class="product-description">
					<i class="fa fa-fw fa-clone"></i> <?= implode(', ', $model->workingsAsTitleArray) ?>
    				<i class="fa fa-fw fa-map-pin"></i> <?= is_array($model->placements) ? implode(', ', $model->placements) : ''  ?>
                    <i class="fa fa-fw fa-commenting"></i> <?= $model->response_counter ?> откликов
            		<i class="fa fa-fw fa-bullseye"></i> <?= $model->view_counter ?> просмотров
            		<i class="fa fa-fw fa-clock-o"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
				</span>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
</div>


