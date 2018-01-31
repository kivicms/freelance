<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\order\models\Order;
use app\widgets\PanelWidget;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php PanelWidget::begin([
	    'title' => $this->title,
	    'buttons' => [
	        Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right'])
	   ]
	])?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'budget')->textInput() ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'budget_type')->dropDownList(Order::itemAlias('BudgetType')) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'money')->checkboxList(Order::itemAlias('MoneyType')) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>	
		</div>
		<div class="col-md-2">
			<?=   
    		$form->field($model, 'deadline')->widget(DateControl::classname(), [
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
		<div class="col-md-1">
			<?= $form->field($model, 'is_archive')->dropDownList(Order::itemAlias('Archive')) ?>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h4>Фотографии</h4>
			<?= \dvizh\gallery\widgets\Gallery::widget(
                [
                    'model' => $model,
                    'previewSize' => '115x115',
                    'fileInputPluginLoading' => true,
                    'fileInputPluginOptions' => []
                ]
            ); ?>
		</div>
		
		<div class="col-md-8">
			<h4>Документы</h4>
			<?= \nemmo\attachments\components\AttachmentsInput::widget([
            	'id' => 'file-input', // Optional
            	'model' => $model,
            	'options' => [ // Options of the Kartik's FileInput widget
            		'multiple' => true, // If you want to allow multiple upload, default to false
            	],
            	'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            		'maxFileCount' => 10 // Client max files
            	]
            ]) ?>
		</div>
	</div>

    <?php // $form->field($model, 'status')->textInput() ?>

    

    <?php // $form->field($model, 'executor_id')->textInput() ?>

	<?php PanelWidget::end()?>
    <?php ActiveForm::end(); ?>

</div>
