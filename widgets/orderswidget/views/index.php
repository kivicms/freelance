<?php 


use yii\widgets\ListView;

?>

<div class="orders-widget">
<?php foreach ($models as $model) : ?>
	<?= $this->render('_list', ['model' => $model] ) ?>
<?php endforeach; ?>
</div>