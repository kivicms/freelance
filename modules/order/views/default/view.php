<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PanelWidget;
use app\modules\order\models\Order;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

	<?php PanelWidget::begin([
	    'title' => $this->title,
	    'buttons' => [
	        Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary pull-right']),
	        Html::a('Удалить', ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger pull-right',
	            'data' => [
	                'confirm' => 'Are you sure you want to delete this item?',
	                'method' => 'post',
	            ],
	        ])
	]
	])?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.profile.title',
            'title',
            'description:ntext',
            [
                'label' => 'Бюджет',
                'value' => Yii::$app->formatter->asCurrency($model->budget, 'RUB') . ' за ' . Order::itemAlias('BudgetType', $model->budget_type)
            ],
            'deadline:date',
            //'status',
            'is_archive',
            'executor_id',
        ],
    ]) ?>
	<?php PanelWidget::end()?>
</div>
