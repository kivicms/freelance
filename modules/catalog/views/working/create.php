<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Working */

$this->title = 'Добавить специализацию';
$this->params['breadcrumbs'][] = ['label' => 'Специализации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
