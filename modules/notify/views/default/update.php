<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\notify\models\Notify */

$this->title = 'Update Notify: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notifies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="notify-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
