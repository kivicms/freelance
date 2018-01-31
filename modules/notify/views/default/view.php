<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PanelWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\notify\models\Notify */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Уведомления системы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notify-view">
<?php PanelWidget::begin([
    'title' => $this->title
])?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'to_user_id',
            'title',
            [
                'attribute' => 'description',
                'format' => 'html'
            ],
            
            'created_at:datetime',
//            'updated_at',
//            'status',
            'readed_time:datetime',
        ],
    ]) ?>
<?php PanelWidget::end() ?>
</div>
