<?php 


use yii\helpers\Url;

?>

<div class="company-item">
	<div class="row">
		<div class="col-md-1">
			<img src="<?= $model->getImage()->getUrl('70x70') ?>" class="img-circle" alt=""/>
		</div>
    	<div class="col-md-8">
    		<h3><a href="<?= Url::toRoute(['/company/default/view', 'id' => $model->id]) ?>"><?= $model->title ?></a></h3>
    	</div>
    	<div class="col-md-3">
    	</div>
    	<div class="col-md-12">
    		
    	</div>
    </div>
</div>
<hr>