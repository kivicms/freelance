<?php 
use yii\helpers\Url;
use yii\helpers\VarDumper;
?>

<?php foreach ($models as $model) : ?>
    <li>
    	<a href="<?= Url::toRoute(['/notify/default/view', 'id' => $model->id]) ?>"> 
    		<i class="fa fa-users text-aqua"></i> <?= $model->title ?>
    	</a>
    </li>
<?php endforeach; ?>