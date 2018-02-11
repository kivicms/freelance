<?php 

use app\widgets\PanelWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Widget;
use app\modules\profile\models\Profile;
use yii\helpers\VarDumper;
use app\widgets\CompanyProfileWidget;

$this->title = 'Мой профиль';

$this->params['breadcrumbs'][] = $this->title;

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
        	    'title' => $this->title,
        	    //'type' => 'success',
        	    'solid' => false,
        	    'buttons' => [
        	       Html::a('Редактировать',['/profile/default/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-info pull-right'])     
        	   ]
        	])?>
        	<?= DetailView::widget([
        	    'model' => $model,
        	    'attributes' => [
        	        [
        	            'label' => 'Логотип или аватар',
        	            'format' => 'html',
        	            'value' => '<img src="' . $model->getImage()->getUrl('100x100') . '" />'
        	        ],            	          
        	        'title',
        	        [
        	            'attribute' => 'type_of_legal',
        	            'value' => Profile::itemAlias('Legal', $model->type_of_legal)
        	        ],
        	        [
        	            'label' => 'Категории',
        	            'value' => implode(', ', $model->workingsAsTitleArray)
        	        ],
        	        'description',
        	        'address_fact',
        	        'address_legal',	        
        	        [
        	           'attribute' => 'is_verified',
        	            'value' => Profile::itemAlias('Verified', $model->is_verified)
        	        ],
        	        [
        	           'label' => 'Контакт',
        	            'value' => $model->getFullFio()
        	       ],
        	        'phone',
        	        'www',
        	        [
        	            'attribute' => 'sex',
        	            'value' => Profile::itemAlias('Sex', $model->sex)
                    ],
        	        'executed_orders'
        	        
        	        
        	   ]
        	]) ?>
        	
        	<h4>Файлы</h4>
        	<?= \nemmo\attachments\components\AttachmentsTable::widget(['model' => $model]) ?>

	<?php PanelWidget::end()?>
		</div>
	</div>
</div>