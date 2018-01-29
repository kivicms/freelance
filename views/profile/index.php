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
	    'buttons' => [
	       Html::a('Редактировать',['/profile/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-info pull-right'])     
	   ]
	])?>
	
	<?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
            [
                'attribute' => 'type_of_legal',
                'value' => Profile::itemAlias('Legal', $model->type_of_legal)
	        ],	           
	        'title',
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
	        [
	            'attribute' => 'sex',
	            'value' => Profile::itemAlias('Sex', $model->sex)
            ]
	        
	        
	   ]
	]) ?>


	<?php PanelWidget::end()?>
</div>