<?php
$this->title = 'Статистика';
$this->params['breadcrumbs'][] = '$this->title'?>


<div class="stat-index">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-yellow">
						<i class="fa fa-fw fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Новых<br>пользователей</span> <span
							class="info-box-number"><?= $newUsers ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</div>
	</div>

</div>