<?php
use app\models\User;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>  -->
                
                <img src="<?= Yii::$app->user->identity->profile->getImage()->getUrl('160x160') ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->profile->shortFio ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Поиск..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->
<?php 
$items = [];
if ( User::hasRole('company', false) && \Yii::$app->user->identity->profile->is_verified) {
    $items[] = ['label' => 'Компании', 'icon' => 'file-code-o', 'url' => ['/company/default/index']];
    $items[] = ['label' => 'Заказы', 'icon' => 'file-code-o', 'url' => ['/order/default/index']];

    $items[] = ['label' => 'Уведомления', 'icon' => 'file-code-o', 'url' => ['/notify/default/index']];
}


if (User::hasRole('Admin')) {

    $items[] = ['label' => 'Справочники', 'options' => ['class' => 'header']];
    $items[] = ['label' => 'Специализации', 'icon' => 'file-code-o', 'url' => ['/catalog/working']];
    $items[] = ['label' => 'Компании', 'icon' => 'file-code-o', 'url' => ['/company/default/index']];
    $items[] = ['label' => 'Заказы', 'icon' => 'file-code-o', 'url' => ['/order/default/index']];
    
    
    $items[] = ['label' => 'Пользователи', 'options' => ['class' => 'header']];
    $items[] = ['label' => 'Пользователи', 'icon' => 'file-code-o', 'url' => ['/user-management/user/index']];
    $items[] = ['label' => 'Роли', 'icon' => 'file-code-o', 'url' => ['/user-management/role/index']];
    $items[] = ['label' => 'Права', 'icon' => 'file-code-o', 'url' => ['/user-management/permission/index']];
    $items[] = ['label' => 'Группы прав', 'icon' => 'file-code-o', 'url' => ['/user-management/auth-item-group/index']];
    $items[] = ['label' => 'История посещений', 'icon' => 'file-code-o', 'url' => ['/user-management/user-visit-log/index']];
    
    
    $items[] = ['label' => 'Menu Yii2', 'options' => ['class' => 'header']];
    $items[] = ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']];
    $items[] = ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']];
}

/* $items[]
$items[]
$items[]
$items[] */

/*  = [
    
    ,
    ,
    
    
    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    [
        'label' => 'Some tools',
        'icon' => 'share',
        'url' => '#',
        'items' => [
            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
            [
                'label' => 'Level One',
                'icon' => 'circle-o',
                'url' => '#',
                'items' => [
                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    [
                        'label' => 'Level Two',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                        ],
                    ],
                ],
            ],
        ],
    ],
]; */


?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $items
            ]
        ) ?>

    </section>

</aside>
