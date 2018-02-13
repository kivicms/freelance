<?php 
use yii\widgets\ActiveForm;
use app\widgets\PanelWidget;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\money\MaskMoney;
use yii\helpers\Url;

/* @var ReponseOrder $response */
?>

<div class="response-order-widget">
<?php PanelWidget::begin([
    'title' => ($model) ? 'Мой отклик' : 'Откликнуться на заказ'
])?>

<?php if (! $model) : ?>	
	<?php $form = ActiveForm::begin([
	    'action' => ['/order/default/response']
	]) ?>
	<?= $form->field($response, 'order_id')->hiddenInput()->label(false) ?>
	<?= $form->field($response, 'from_user_id')->hiddenInput()->label(false) ?>
	
    <div class="row">
    	<div class="col-md-4">
    		<?=   
    		$form->field($response, 'start')->widget(DateControl::classname(), [
    		    'type'=>DateControl::FORMAT_DATE,
    		    'ajaxConversion'=>false,
    		    'saveFormat' => 'php:Y-m-d',
    		    'displayFormat' => 'php:d.m.Y',
    		    'widgetOptions' => [
    		        'pluginOptions' => [
    		            'autoclose' => true
    		        ]
    		    ]
    		]);
    		?>
    	</div>
    	<div class="col-md-4">
    		<?=   
    		$form->field($response, 'end')->widget(DateControl::classname(), [
    		    'type'=>DateControl::FORMAT_DATE,
    		    'ajaxConversion'=>false,
    		    'saveFormat' => 'php:Y-m-d',
    		    'displayFormat' => 'php:d.m.Y',
    		    'widgetOptions' => [
    		        'pluginOptions' => [
    		            'autoclose' => true
    		        ]
    		    ]
    		]);
    		?>
    	</div>
    	<div class="col-md-4">
    		<?=  
    		$form->field($response, 'cost')->widget(MaskMoney::classname(), [
			    'pluginOptions' => [
			        'allowNegative' => false
			    ]
			]);
			?>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-12">
    		<?= $form->field($response, 'response')->textarea(['rows' => 4]) ?>		
    		
    		<?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    	</div>
    </div>
    <?php ActiveForm::end() ?>

<?php else :?>

	<div class="row">
		<div class="col-md-12">
			<div class="user-block">
                <img class="img-circle" src="<?= $order->profile->getImage()->getUrl('128x128') ?>" alt="<?= $order->profile->getFullCompanyName() ?>">
                <span class="username"><a href="<?= Url::toRoute(['/company/default/view', 'id' => $order->profile->id]) ?>"><?= $order->profile->getFullCompanyName() ?></a></span>
                <span class="label label-success pull-right">Стоимость: <?= Yii::$app->formatter->asCurrency($model->cost) ?></span>
                <span class="description"><strong>Срок исполнения: с <?= Yii::$app->formatter->asDate($model->start) ?> по <?= Yii::$app->formatter->asDate($model->end) ?></strong><br>
					<?= $model->response ?>
                </span>
                
        	</div>
		</div>
		<div class="col-md-12">
			<div class="comments-inner-widget  bg-aqua color-palette disabled">
			<?= \yii2mod\comments\widgets\Comment::widget([
                'model' => $model,
            ]); ?>
            </div>
		</div>
	</div>
<?php endif; ?>
<?php PanelWidget::end() ?>
</div>
<style>
.comments-inner-widget {
	margin: 20px 0px;
	padding: 5px 10px;
}
</style>