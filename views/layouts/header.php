<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\notifywidget\NotifyWidget;
use yii\base\Widget;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">RN</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

               
                <?= NotifyWidget::widget() ?>
                
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/> --> 
                        
                        <img src="<?= Yii::$app->user->identity->profile->getImage()->getUrl('160x160') ?>" class="user-image" alt="User Image"/>
                        
                        <span class="hidden-xs"><?= Yii::$app->user->identity->profile->shortFio ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">

							<img src="<?= Yii::$app->user->identity->profile->getImage()->getUrl('160x160') ?>" class="img-circle" alt="User Image"/>
                            
                            <p>
                                <?= Yii::$app->user->identity->profile->fullCompanyName ?>
                                <small>Участник с <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->profile->created_at) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::toRoute(['/profile/default/index']) ?>" class="btn btn-default btn-flat">Профиль</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выйти',
                                    ['/user-management/auth/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
