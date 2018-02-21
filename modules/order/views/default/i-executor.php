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

$this->title = 'Я исполнитель';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php PanelWidget::begin([
        'title' => $this->title,
    ])?>
    
        <div class="row">
    	<div class="col-md-6">
    		<?= OrderButtonsWidget::widget(['active' => 'i-executor']) ?>	
    	</div>
    	<div class="col-md-6 pull-right" >
    		<?= OrderSearchWidget::widget(['model' => $searchModel, 'status' => true, 'searchStatus' => 'SearchStatusExecutor']) ?>	
    	</div>
    </div>
	<hr>
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]) ?>
    
    
    <?php PanelWidget::end() ?>
</div>
