<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var ActiveDataProvider $dataProvider  */
?>

<?php Pjax::begin([
    'id' => 'i-following',
    'enablePushState' => false
]) ?>
<div class="i-following-widget">
<?= Html::beginForm(['/profile/default/i-following'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::input('text', 'ProfileSearch[title]', Yii::$app->request->post('ProfileSearch[title]'), ['class' => 'form-control']) ?>
    <?= Html::submitButton('Найти', ['class' => 'btn btn-sm btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>

	<?= ListView::widget([
        'dataProvider' => $dataProvider,
	    'itemView' => '_foll',
	    'options' => ['class' => 'products-list product-list-in-box'],
	    
    ]) ?>
</div>
<?php Pjax::end() ?>