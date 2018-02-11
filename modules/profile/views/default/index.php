<?php 

use app\widgets\PanelWidget;

use yii\base\Widget;
use app\modules\profile\models\Profile;
use yii\helpers\VarDumper;
use app\widgets\CompanyProfileWidget;
use yii\bootstrap\Tabs;
use app\widgets\followers\MyFollowersWidget;
use app\widgets\followers\IFollowingWidget;
use app\widgets\orderswidget\OrdersWidget;
use app\widgets\orders\IExecutorOrderWidget;
use app\widgets\orders\ICustomerOrderWidget;

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
        	    'title' => 'Подробности',
        	    'type' => 'success',
        	    'solid' => false,
        	    'buttons' => [
        	       // Html::a('Редактировать',['/profile/default/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-info pull-right'])     
        	   ]
        	])?>
        	
        	<?= Tabs::widget([
        	    'encodeLabels' => false,
        	    'items' => [
        	       [
        	           'label' => 'Я исполнитель',
        	           'content' => IExecutorOrderWidget::widget(),
        	           'active' => true
        	       ],[
        	           'label' => 'Я заказчик',
        	           'content' => ICustomerOrderWidget::widget(),
        	       ],[
        	           'label' => 'Мои подписчики',
        	           'content' => MyFollowersWidget::widget(),
        	       ],[
        	           'label' => 'Я подписан',
        	           'content' => IFollowingWidget::widget(),
        	       ] 
        	   ]
        	]) ?>
        	
			<?php PanelWidget::end()?>
		</div>
	</div>
</div>