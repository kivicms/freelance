<?php 

use app\widgets\PanelWidget;
use app\modules\profile\models\Profile;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Неподтвержденные пользователи';
$this->params['breadcrumbs'][] = $this->title;

/* @var Profile $models  */
/* @var yii\web\View $this */
?>

<div class="profile-verify-index">
	<?php PanelWidget::begin([
	    'title' => $this->title
	])?>
	<?php Pjax::begin(['enablePushState' => false]) ?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-condensed">	
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Наименование</th>
					<th class="text-center">ФИО</th>
					<th class="text-center">Телефон</th>
					<th class="text-center">Тип</th>
					<th class="text-center">Направление</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($models as $model) : ?>
				<tr>
					<td class="text-center"><?= Html::a('Подтвердить',['/profile/admin/index', 'id' => $model->id])?></td>
					<td class="text-center"><?= Html::a($model->title,['/profile/admin/view', 'id' => $model->id], ['target'=>'_blank']) ?></td>
					<td class="text-center"><?= $model->fullFio ?></td>
					<td class="text-center"><?= $model->phone ?></td>
					<td class="text-center"><?= Profile::itemAlias('ShortLegal', $model->type_of_legal) ?></td>
					<td class="text-center"><?= implode(', ', $model->workingsAsTitleArray) ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php Pjax::end() ?>
	<?php PanelWidget::end()?>
</div>