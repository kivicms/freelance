<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\PanelWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\catalog\models\WorkingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Специализации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-index">

<?php PanelWidget::begin([
    'title' => $this->title,
    'buttons' => [
        Html::a('Добавить', ['create'], ['class' => 'btn btn-success pull-right'])
    ]
])?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <?php PanelWidget::end()?>
</div>
