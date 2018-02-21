<?php 

use kartik\form\ActiveForm;
use app\modules\order\models\Order;
use yii\helpers\Html;

?>

<div class="order-search-widget pull-right">
	<?php $form = ActiveForm::begin([
	    'type' => ActiveForm::TYPE_INLINE,
	    'fieldConfig' => ['autoPlaceholder'=>true]
	]) ?>
	<?= $form->field($model, 'title')->textInput(['placeholder' => 'Наименование']) ?>
	
	<?php if ($status) : ?>
		<?= $form->field($model, 'status')->dropDownList(Order::itemAlias($searchStatus),['prompt' => 'Статус...']) ?>	
		<?= $form->field($model, 'is_archive')->checkbox(['class' => 'icheckbox_minimal-blue']) ?>
	<?php endif;?>
	
	<?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
	
	<?php ActiveForm::end() ?>
</div>