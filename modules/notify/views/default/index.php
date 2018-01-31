<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\PanelWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\notify\models\NotifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Уведомления системы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notify-index">
<?php PanelWidget::begin([
    'title' => $this->title
])?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'to_user_id',
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a($model->title,['/notify/default/view', 'id' => $model->id]);
                }
            ],
            'description:html',
            
            'created_at:datetime',
            //'updated_at',
            //'status',
            [
                'attribute' => 'readed_time',
                'value' => function($model) {
                    if (! $model->status) {
                        return 'Не прочитано';
                    } else {
                        return Yii::$app->formatter->asDatetime($model->readed_time);
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>
<?php PanelWidget::end() ?>
</div>
