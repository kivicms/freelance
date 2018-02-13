<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\CompanyProfileWidget;
use yii\base\Widget;
use app\widgets\PanelWidget;
use app\widgets\orderswidget\OrdersWidget;
use app\widgets\AboutUsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

	<div class="row">
		<div class="col-md-3">
			<?= CompanyProfileWidget::widget(['model' => $model])  ?>
			<?= AboutUsWidget::widget(['model' => $model]) ?>
		</div>
		<div class="col-md-5">
    		<?php PanelWidget::begin([
    		    'title' => 'Заказы'
    		])?>
    
    		<?= OrdersWidget::widget(['profile' => $model]) ?>
    
    
            <?php /* DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'user_id',
                    'lastname',
                    'firstname',
                    'middlename',
                    'sex',
                    'phone',
                    'www',
                    'type_of_legal',
                    'title',
                    'description:ntext',
                    'address_fact',
                    'address_legal',
                    'is_verified',
                    'executed_orders',
                    'created_at',
                    'updated_at',
                    'follower_counter',
                    'following_counter',
                    'order_placed_counter',
                    'order_actual_counter',
                ],
            ]) */ ?>
    		
		
			<?php PanelWidget::end() ?>	
		</div>
		<div class="col-md-4">
			<?php PanelWidget::begin([
    		    'title' => 'Чат'
    		])?>
    		Тут будет мой чат с компанией
    		<?php PanelWidget::end() ?>
		</div>	
	</div>

    
</div>
