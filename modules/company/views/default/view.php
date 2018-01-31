<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'lastname',
            'firstname',
            'middlename',
            'sex',
            'phone',
            'www',
            'type_of_legal',
            'title',
            'description:ntext',
            'address_fact',
            'address_legal',
            'is_verified',
            'executed_orders',
            'created_at',
            'updated_at',
            'follower_counter',
            'following_counter',
            'order_placed_counter',
            'order_actual_counter',
        ],
    ]) ?>

</div>
