<?php
use yii\helpers\Url;

?>
<?php if (count($models) > 0) : ?>
<li class="dropdown notifications-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
		<i class="fa fa-bell-o"></i>
		<span class="label label-warning" id="notify-counter"><?= count($models) ?></span>
	</a>
	<ul class="dropdown-menu">
		<li class="header">У Вас <?= count($models) ?> уведомлений</li>
		<li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu" id="notify-menu">
				<?php foreach ($models as $model) : ?>
				<li>
					<a href="<?= Url::toRoute(['/notify/default/view', 'id' => $model->id]) ?>"> 
						<i class="fa fa-users text-aqua"></i> <?= $model->title ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<li class="footer"><a href="<?= Url::toRoute(['/notify/default/index']) ?>">Смотреть все</a></li>
	</ul>
</li>
<?php endif; ?>

<?php 
$this->registerJs('

/* setInterval(function() {
    $.get("' . Url::toRoute(['/notify/default/list-active']) . '",{}, function(data) {
        $("#notify-counter").empty().append(data.counter);
        $("#notify-menu").empty().append(data.content);
    }, "json");
}, 10000); */
');

?>