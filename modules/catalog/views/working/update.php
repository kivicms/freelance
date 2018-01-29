<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Working */

$this->title = 'Редактирование специализации: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Специализации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="working-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
