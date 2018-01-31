<?php 


use yii\widgets\ActiveForm;
use app\widgets\PanelWidget;
use yii\helpers\Html;

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
    	<div class="col-md-12">
    		<?= $form->field($response, 'response')->textarea(['rows' => 4]) ?>		
    		
    		<?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    	</div>
    </div>
    <?php ActiveForm::end() ?>

<?php else :?>

	<div class="row">
		<div class="col-md-12">
		<p><?= $model->response ?></p>	
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