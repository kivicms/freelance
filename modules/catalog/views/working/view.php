<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PanelWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Working */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Специализации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-view">

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
            'parentWorking.title',
            'title',
        ],
    ]) ?>

<?php PanelWidget::end() ?>
</div>
