<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PanelWidget;
use app\modules\order\models\Order;
use app\widgets\CompanyProfileWidget;
use yii\base\Widget;
use app\widgets\responseorder\ResponseOrderWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
	<div class="row">
		<div class="col-md-3">
			<?= CompanyProfileWidget::widget([
			    'model' => $model->profile
			]) ?>
		</div>	
		<div class="col-md-9">
			<?php 
			$buttons = [];
			if ($model->user_id == Yii::$app->user->id) {
			    $buttons = [
			        Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary pull-right']),
   			        Html::a('Удалить', ['delete', 'id' => $model->id], [
    			        'class' => 'btn btn-danger pull-right',
    			        'data' => [
    			            'confirm' => 'Are you sure you want to delete this item?',
    			            'method' => 'post',
    			        ],
    			    ])
			   ];
			}
			
			?>
		
        	<?php PanelWidget::begin([
        	    'title' => $this->title,
        	    'buttons' => $buttons    
        	])?>
        	<div class="row">
        		<div class="col-md-12">
        			<img class="img-circle img-bordered-sm" src="<?= $model->getImage()->getUrl('50x50') ?>" style="float: left">
        			<h2><?= $model->title ?></h2>
      				<span class="text-green"><strong>
      					<?= Yii::$app->formatter->asCurrency($model->budget, 'RUR') . ' ' 
                            . Order::itemAlias('BudgetType', $model->budget_type) ?></strong></span> • 
                            
                    <span><?= implode(', ', $model->moneyTypesAsArray) ?></span>                    
        		</div>
        		<div class="col-md-12">
        			<?= Yii::$app->formatter->asDatetime($model->created_at) ?>  • 
        			<?= '2' ?> отклика  • 
        			<?= $model->view_counter ?> просмотров
        		</div>
        		<br>
        		<div class="col-md-12">
        			<?= $model->description ?>
        		</div>
        		
        		<?php if (count($model->files) > 0) : ?>
        		<div class="col-md-12">
        		<h4>Файлы</h4>
					<?= \nemmo\attachments\components\AttachmentsTable::widget(['model' => $model]) ?>
        		</div>
        		<?php endif; ?>
        		
        		<?php $images = $model->getImages(); ?>
            	<?php if (count($images) > 1) : ?>
            	
        			<?php 
        			$items = [];
        			foreach ($images as $img ) {
        			     $items[] = [
        			         'url' => $model->image->getUrl(),
        			         'src' => $img->getUrl('200px200px')
        			     ];
        			} ?>
        			<div class="col-md-12">
        			<h4>Фотографии</h4>
        			<?= dosamigos\gallery\Gallery::widget(['items' => $items]);?>
        			</div>
                <?php endif; ?>
        		
        	</div>
        	
        	
        	
        	<?php PanelWidget::end()?>
        	<br>
        	<?= ResponseOrderWidget::widget(['order' => $model]) ?>
		</div>	
	</div>	
</div>
