<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\PanelWidget;
use yii\widgets\ListView;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\order\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php PanelWidget::begin([
        'title' => $this->title,
    ])?>
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]) ?>
    
    
    <?php PanelWidget::end() ?>
</div>