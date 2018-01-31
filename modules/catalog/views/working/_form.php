<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\debug\Panel;
use app\widgets\PanelWidget;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\Working;

/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Working */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="working-form">

    <?php $form = ActiveForm::begin(); ?>
	<?php PanelWidget::begin([
	    'title' => $this->title,
	    'buttons' => [
	        Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary pull-right'])
	   ]
	])?>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'parent_id')->dropDownList(
			    ArrayHelper::map(
			        Working::find()->where('parent_id=0')->orderBy('title')->all(), 
			        'id', 'title'),[
			    'prompt' => 'Выберите родительскую категорию'        
			]) ?>	
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>	
		</div>
	</div>
	<?php PanelWidget::end() ?>
    <?php ActiveForm::end(); ?>
</div>
