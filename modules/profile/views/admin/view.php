<?php

use app\widgets\PanelWidget;

use yii\base\Widget;
use app\modules\profile\models\Profile;
use app\widgets\CompanyProfileWidget;
use app\widgets\followers\MyFollowersWidget;
use app\widgets\followers\IFollowingWidget;
use app\widgets\orders\IExecutorOrderWidget;
use app\widgets\orders\ICustomerOrderWidget;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use app\widgets\AboutUsWidget;
use yii\widgets\DetailView;

$this->title = 'Профиль пользователя ' . $model->title;

$this->params['breadcrumbs'][] = $this->title;
/* @var Profile $model */
?>

<div class="profile-index">
	<div class="row">
		<div class="col-md-3">
			<?= CompanyProfileWidget::widget([ 
			    'model' => $model
			]) ?>
		</div>	
		<div class="col-md-9">
        	<?php PanelWidget::begin([
        	    'title' => 'Подробности',
        	    'type' => 'success',
        	    'solid' => false,
        	    'buttons' => [
        	       // Html::a('Редактировать',['/profile/default/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-info pull-right'])     
        	   ]
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
        	
        	
			<?php PanelWidget::end()?>
		</div>
	</div>
</div>