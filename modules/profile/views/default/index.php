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
        	
        	<?= Tabs::widget([
        	    'encodeLabels' => false,
        	    'items' => [
        	       [
        	           'label' => 'Я исполнитель <span class="badge bg-light-blue">' . $model->executed_orders. '</span>',
        	           'content' => IExecutorOrderWidget::widget(),
        	           'active' => (! isset($_GET['tab']) || isset($_GET['tab']) && $_GET['tab'] == 'iexecutor') ? true : false
        	       ],[
        	           'label' => 'Я заказчик <span class="badge bg-light-blue">' . $model->order_actual_counter. '</span>',
        	           'content' => ICustomerOrderWidget::widget(),
        	           'active' => (isset($_GET['tab']) && $_GET['tab'] == 'icustomer') ? true : false
        	       ],[
        	           'label' => 'Мои подписчики <span class="badge bg-light-blue">' . $model->follower_counter. '</span>',
        	           'content' => MyFollowersWidget::widget(),
        	           'active' => (isset($_GET['tab']) && $_GET['tab'] == 'myfollowers') ? true : false
        	       ],[
        	           'label' => 'Я подписан <span class="badge bg-light-blue">' . $model->following_counter. '</span>',
        	           'content' => IFollowingWidget::widget(),
        	           'active' => (isset($_GET['tab']) && $_GET['tab'] == 'ifollowing') ? true : false
        	       ] 
        	   ]
        	]) ?>
        	
			<?php PanelWidget::end()?>
		</div>
	</div>
</div>