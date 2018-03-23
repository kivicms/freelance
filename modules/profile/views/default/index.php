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
        	
        	<?= TabsX::widget([
        	    'encodeLabels' => false,
        	    'enableStickyTabs'=>true,
        	    'items' => [
            	    [
            	        'label' => 'О нас',
            	        'content' => AboutUsWidget::widget(['model' => $model]),
            	        'active' => (! isset($_GET['tab']) || (isset($_GET['tab']) && $_GET['tab'] == 'aboutus')) ? true : false
            	    ],
        	        [
        	           'label' => 'Подробная информация',
        	            'content' => $this->render('_detail', ['model' => $model]),
        	       ],
        	       [
        	           'id' => 'my-followers',
        	           'label' => 'Мои подписчики <span class="badge bg-light-blue">' . $model->follower_counter. '</span>',
        	           'linkOptions'=>['data-url'=>Url::to(['/profile/default/my-followers'])],
        	           'active' => (isset($_GET['tab']) && $_GET['tab'] == 'myfollowers') ? true : false
        	       ],
        	       [
        	           'label' => 'Я подписан <span class="badge bg-light-blue">' . $model->following_counter. '</span>',
        	           'linkOptions'=>['data-url'=>Url::to(['/profile/default/i-following'])],
        	           'active' => (isset($_GET['tab']) && $_GET['tab'] == 'ifollowing') ? true : false
        	       ],
        	   ]
        	]) ?>
        	
			<?php PanelWidget::end()?>
		</div>
	</div>
</div>
