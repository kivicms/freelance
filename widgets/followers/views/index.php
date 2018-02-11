<?php
use yii\helpers\Url;

?>

<div class="followers-widget">
	<ul class="products-list product-list-in-box">
		<?php foreach ($models as $model) : ?>		
		<li class="item">
			<div class="product-img">
				<img src="<?= $model->getImage()->getUrl('70x70') ?>" alt="<?= $model->title ?>">
			</div>
			<div class="product-info">
				<a href="<?= Url::toRoute(['/company/default/view', 'id' => $model->id]) ?>" class="product-title"><?= $model->title ?>
					<span class="label label-warning pull-right">$1800</span>
				</a> 
				<span class="product-description"><?= implode(', ', $model->workingsAsTitleArray) ?>
				</span>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
</div>