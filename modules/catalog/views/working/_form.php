<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\debug\Panel;
use app\widgets\PanelWidget;

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
    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?php PanelWidget::end() ?>
    <?php ActiveForm::end(); ?>

</div>
