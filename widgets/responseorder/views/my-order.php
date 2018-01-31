<?php 


use app\widgets\PanelWidget;
use yii\helpers\Url;

?>

<div class="response-my-order-widget">
<?php PanelWidget::begin([
    'title' => 'Отклики на мой заказ'
])?>
	<?php if (count($models) == 0) : ?>

        <div class="alert alert-warning alert-dismissible">
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        	<h4><i class="icon fa fa-warning"></i> Внимание!</h4>
        	На данный заказ у Вас пока нет ни одного отклика.
        </div>

	<?php else: ?>
		
		<?php foreach ($models as $model) : ?>
		<div class="row">
			<div class="col-md-1">
				<img src="<?= $model->fromUser->profile->getImage()->getUrl('128x128') ?>" class="profile-user-img img-responsive img-circle" />				
			</div>
			<div class="col-md-9">
				<a href="<?= Url::toRoute(['/company/default/view', 'id' => $model->fromUser->profile->id]) ?>"><?= $model->fromUser->profile->fullCompanyName ?></a>&nbsp;&nbsp;&nbsp;
				<span class="text-muted"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span><br>
				<span class="text-info"><?= $model->fromUser->profile->fullFio ?></span>
				<p><?= $model->response ?></p>
			</div>
			<div class="col-md-2">
				<?php if ($order->executor_id == 0) : ?>
				<a class="btn btn-warning" href="<?= Url::toRoute(['/order/default/set-executor', 'id' => $order->id, 'executor_id' => $model->from_user_id]) ?>">
                	<i class="fa fa-bullhorn"></i> Назначить<br>исполнителем
              	</a>
              	<?php endif; ?>
			</div>
			<div class="col-md-12">
				<a href="#comments-block-<?= $model->id ?>" class="btn btn-default" data-toggle="collapse">Комментарии</a>
				
				<div class="comments-inner-widget  bg-aqua color-palette disabled collapse" id="comments-block-<?= $model->id ?>">
        			<?= \yii2mod\comments\widgets\Comment::widget([
                        'model' => $model,
        			    'formId' => 'comment-form' . $model->id,
        			    'pjaxContainerId' => 'unique-pjax-container-' .$model->id,
        			   // 'commentView' => '@app/views/comments/index'
                    ]); ?>
                </div>
    		</div>
		</div>
		<hr>
		<?php endforeach; ?>
		
	<?php endif; ?>
<?php PanelWidget::end() ?>
</div>
<style>
.comments-inner-widget {
	margin: 20px 0px;
	padding: 5px 10px;
}
</style>