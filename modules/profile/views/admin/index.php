<?php 

use app\widgets\PanelWidget;
use app\modules\profile\models\Profile;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

$this->title = 'Неподтвержденные пользователи';
$this->params['breadcrumbs'][] = $this->title;

/* @var Profile $models  */
/* @var yii\web\View $this */
?>

<div class="profile-verify-index">
	<?php PanelWidget::begin([
	    'title' => $this->title
	])?>
	<?php // Pjax::begin(['enablePushState' => false]) ?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-condensed">	
			<thead>
				<tr>
					<th class="text-center">Наименование</th>
					<th class="text-center">ФИО</th>
					<th class="text-center">Телефон</th>
					<th class="text-center">Тип</th>
					<th class="text-center">Направление</th>
					<th class="text-center">Подробно</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($models as $model) : ?>
				<tr>
					<td class="text-center"><?= Html::a($model->title,['/profile/admin/view', 'id' => $model->id], ['target'=>'_blank']) ?></td>
					<td class="text-center"><?= $model->fullFio ?></td>
					<td class="text-center"><?= $model->phone ?></td>
					<td class="text-center"><?= Profile::itemAlias('ShortLegal', $model->type_of_legal) ?></td>
					<td class="text-center"><?= implode(', ', $model->workingsAsTitleArray) ?></td>
					<td class="text-center">
						
						
						
						<?php Modal::begin([
						    'header' => 'Детализация',
						    'toggleButton' => [
						          'label' => '<i class="fa fa-fw fa-eye"></i> Просмотреть',
						          'class' => 'btn btn-info'
						    ],
						])?>
    						<?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'fullFio',
                                    'email',
                                    [
                                        'attribute' => 'sex',
                                        'value' => Profile::itemAlias('Sex', $model->sex),
        					        ],
                                    'phone',
                                    'www',
                                    [
                                        'attribute' => 'type_of_legal',
                                        'value' => Profile::itemAlias('Legal', $model->type_of_legal)
        					        ],
                                    'inn',
                                    'kpp',
                                    'ogrn',
                                    'ogrnip',
                                    'position',
                                    'fullCompanyName',
                                    [
                                        'attribute' => 'workingsAsTitleArray',
                                        'value' => implode(', ', $model->workingsAsTitleArray)
                                    ],
                                    'description:ntext',
                                    'address_fact',
                                    'address_legal',
                                ]
                            ])?>
						
							<?php $form = ActiveForm::begin([
                                'action' => ['/profile/admin/refuse', 'id' => $model->id],
                            ]); ?>
							
							<?= $form->field($model, 'refuse_content')->textarea(['cols' => 4]) ?>
							
							<?= Html::a('<i class="fa fa-fw fa-plus"></i> Подтвердить',['/profile/admin/index', 'id' => $model->id], ['class' => 'btn btn-success'])?>
							
							<?= Html::submitButton('<i class="fa fa-fw fa-exclamation"></i> Отказать',['class' => 'btn btn-warning'])?>
							
							<?php ActiveForm::end() ?>
						
						<?php Modal::end() ?>
					
						
					</td>
				</tr>

			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php // Pjax::end() ?>
	<?php PanelWidget::end()?>
</div>
