<?php 

use yii\helpers\Url;

?>
<div class="row">
	<div class="col-md-12">		
        <div class="item">
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
        </div>
	</div>
</div>
<hr>