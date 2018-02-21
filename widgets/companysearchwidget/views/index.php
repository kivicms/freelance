<?php 

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
   'layout' => 'inline' 
])?>

<?= $form->field($model, 'title')->textInput() ?>

<?= Html::submitButton('Найти', ['class' => 'btn btn-success'])?>

<?php ActiveForm::end() ?>