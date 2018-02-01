<?php 

use app\widgets\PanelWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Widget;
use app\models\Profile;

$this->title = 'Мой профиль';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="profile-index">
	<?php PanelWidget::begin([
	    'title' => $this->title,
	    //'type' => 'success',
	    'solid' => false,
	    'buttons' => [
	       Html::a('Редактировать',['/profile/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-info pull-right'])     
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