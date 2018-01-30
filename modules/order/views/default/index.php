<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\PanelWidget;
use yii\widgets\ListView;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\order\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php PanelWidget::begin([
        'title' => $this->title,
        'buttons' => [
            Html::a('Добавить заказ', ['create'], ['class' => 'btn btn-success'])
        ]
    ])?>
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]) ?>
    
    
    <?php PanelWidget::end() ?>

    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'title',
            'description:ntext',
            'budget',
            //'deadline',
            //'status',
            //'is_archive',
            //'executor_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>
</div>
