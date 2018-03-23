<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\PanelWidget;
use yii\widgets\ListView;
use yii\base\Widget;
use app\widgets\orders\OrderButtonsWidget;
use app\widgets\orders\OrderSearchWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\order\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Я заказчик';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php PanelWidget::begin([
        'title' => $this->title,
        'buttons' => [
            Html::a('Добавить заказ', ['create'], ['class' => 'btn btn-success'])
        ]
    ])?>
    
    <div class="row">
    	<div class="col-md-6">
    		<?= OrderButtonsWidget::widget(['active' => 'i-customer']) ?>	
    	</div>
    	<div class="col-md-6 pull-right" >
    		<?= OrderSearchWidget::widget(['model' => $searchModel, 'status' => true, 'searchStatus' => 'SearchStatusCustomer']) ?>	
    	</div>
    </div>
	<hr>
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]) ?>
    
    
    <?php PanelWidget::end() ?>
</div>
