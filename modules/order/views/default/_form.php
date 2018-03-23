<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\order\models\Order;
use app\widgets\PanelWidget;
use kartik\datecontrol\DateControl;
use kartik\money\MaskMoney;
use kartik\widgets\Select2;
use app\modules\catalog\models\Working;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'validationUrl' => [
            '/order/default/validate'
        ]
    ]); ?>
    
	<?php PanelWidget::begin([
	    'title' => $this->title,
	    'boxFooter' => [
	        Html::submitButton('Сохранить', ['class' => 'btn btn-success'])
	   ]
	])?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
			<?php
			echo $form->field($model, 'w_ids')->widget(
    			Select2::className(), [
    			    'name' => 'kv-state-240', 
    			    'data' => Working::loadItemsWithParent(),
    			    'size' => Select2::MEDIUM,
    			    'options' => ['placeholder' => 'Выберите категорию ...', 'multiple' => true],
    			    'pluginOptions' => [
    			        'tags' => true,
    			        'allowClear' => true
    			    ],
    			]
			)
			?>
		</div>

		<div class="col-md-6">
			<?php
			echo $form->field($model, 'placements')->widget(
    			Select2::className(), [
    			    'name' => 'kv-state-240', 
    			    // 'data' => Working::loadItemsWithParent(),
    			    'size' => Select2::MEDIUM,
    			    'options' => ['placeholder' => 'Выберите местоположение ...', 'multiple' => true],
    			    'pluginOptions' => [
    			        'tags' => true,
    			        'allowClear' => true
    			    ],
    			]
			)
			?>
		</div>
		<div class="col-md-1">
			<?= $form->field($model, 'valuta')->dropDownList(Order::itemAlias('Valuta'),['encode' =>false]) ?>
		</div>
		<div class="col-md-2">
			<?=  
			$form->field($model, 'budget')->widget(MaskMoney::classname(), [
			    'pluginOptions' => [
			        'allowNegative' => false,
			        'prefix' => '$ ',
			    ]
			]);
			?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'budget_type')->dropDownList(Order::itemAlias('BudgetType')) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'money')->checkboxList(Order::itemAlias('MoneyType')) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>	
		</div>
		<div class="col-md-3">
			<?=   
    		$form->field($model, 'start')->widget(DateControl::classname(), [
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
		<div class="col-md-3">
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
		<div class="col-md-3">
			<?= $form->field($model, 'status')->dropDownList(Order::itemAlias('ShortStatus')) ?>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			
			<?= \dvizh\gallery\widgets\Gallery::widget(
                [
                    'model' => $model,
                    'label' => 'Фотографии',
                    'previewSize' => '115x115',
                    'fileInputPluginLoading' => true,
                    'fileInputPluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Выбрать фото'
			         ]
                ]
            ); ?>
		</div>
		
		<div class="col-md-6">
			<h4>Документы</h4>
			<?= \nemmo\attachments\components\AttachmentsInput::widget([
            	'id' => 'file-input', // Optional
            	'model' => $model,
            	'options' => [ // Options of the Kartik's FileInput widget
            		'multiple' => true, // If you want to allow multiple upload, default to false
            	],
            	'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            	    'maxFileCount' => 10, // Client max files
            	    'showCaption' => false,
            	    'showRemove' => false,
            	    'showUpload' => false,
            	    'browseClass' => 'btn btn-primary btn-block',
            	    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            	    'browseLabel' =>  'Выберите файлы'
            	]
            ]) ?>
		</div>
	</div>

	<?php PanelWidget::end()?>
    <?php ActiveForm::end(); ?>

</div>

<?php 
$this->registerCss('
div.kv-file-content img.file-preview-image {
    /* width: 213px; */
    height: 160px;
}
div.file-caption {
    display: none;
}
a.fileinput-upload-button, button.fileinput-upload-button {
    display: none;
}
')
?>
