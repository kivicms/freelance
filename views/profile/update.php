<?php 
/*
 * @var $this yii\web\View
 * @var $model backend\models\Profile
 */

use app\widgets\PanelWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\widgets\Alert;
use yii\base\Widget;
use app\models\Profile;
use kartik\datecontrol\DateControl;

$this->title = 'Редактирование профиля';
$this->params['breeadcrumbs'][] = $this->title;
?>
<?= Alert::widget()?>
<div class="profile-update">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php PanelWidget::begin([
	    'title' => $this->title,
	    'buttons' => [
	        Html::a('Назад', ['index'], ['class' => 'btn btn-info pull-right']),
	        Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right'])
	   ]
	]) ?>
	<?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
	
	<h4>Общая информация</h4>
	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'address_legal')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'address_fact')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'type_of_legal')->dropDownList([0 => 'ООО', 1 => 'ИП']) ?>	
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'www')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-12">
			<?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
		</div>
	</div>

	<h4>Контактные данные</h4>	
	<div class="row">
		<div class="col-md-3">
			<?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>	
		</div>		
		<div class="col-md-3">
			<?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>	
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>	
		</div>				
		<div class="col-md-3">
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>	
		</div>
	</div>
	
	<div class="row">
			
		<div class="col-md-4">
		
			<?= $form->field($model, 'sex')->dropDownList([0 => 'Женский', 1 => 'Мужской']) ?>	
		
			<h4>Аватар</h4>
    		<?= \dvizh\gallery\widgets\Gallery::widget(
                [
                    'model' => $model,
                    'previewSize' => '50x50',
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
	
	<?php  PanelWidget::end() ?>
    <?php ActiveForm::end(); ?>

</div>

<?php /* 
    		$form->field($model, 'birthday')->widget(DateControl::classname(), [
    		    'type'=>DateControl::FORMAT_DATE,
    		    'ajaxConversion'=>false,
    		    'saveFormat' => 'php:Y-m-d',
    		    'displayFormat' => 'php:d.m.Y',
    		    'widgetOptions' => [
    		        'pluginOptions' => [
    		            'autoclose' => true
    		        ]
    		    ]
    		]);*/
    		?>