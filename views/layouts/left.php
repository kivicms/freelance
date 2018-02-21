<?php
use app\models\User;
use yii\helpers\Url;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>  -->
                <a href="<?= Url::toRoute(['/profile/default/index']) ?>">
                	<img src="<?= Yii::$app->user->identity->profile->getImage()->getUrl('45x45') ?>" class="img-circle" alt="User Image"/>
                </a>
            </div>
            <div class="pull-left info">            
                <p>
                	<a href="<?= Url::toRoute(['/profile/default/index']) ?>">
                		<?= Yii::$app->user->identity->profile->shortFio ?>
                	</a>
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

<?php 
$items = [];
if ( User::hasRole('company', false) && \Yii::$app->user->identity->profile->is_verified) {
    $items[] = ['label' => 'Компании', 'icon' => 'file-code-o', 'url' => ['/company/default/index']];
    $items[] = ['label' => 'Заказы', 'icon' => 'file-code-o', 'url' => ['/order/default/index'],
        /* 'items' => [
            ['label' => 'Все', 'icon' => 'file-code-o', 'url' => ['/order/default/index']],
            ['label' => 'Я заказчик', 'badge' => \Yii::$app->user->identity->profile->order_actual_counter, 'icon' => 'file-code-o', 'url' => ['/profile/default/index', 'tab' => 'icustomer']],
            ['label' => 'Я исполнитель', 'badge' => \Yii::$app->user->identity->profile->executed_orders, 'icon' => 'file-code-o', 'url' => ['/profile/default/index', 'tab' => 'iexecutor']],
        ] */
    ];
    
    $items[] = ['label' => 'Друзья', 'icon' => 'file-code-o', 'url' => ['/profile/default/index'],
        'items' => [
            ['label' => 'Я подписан', 'badge' => \Yii::$app->user->identity->profile->following_counter,  'icon' => 'file-code-o', 'url' => ['/profile/default/index', 'tab' => 'ifollowing']],
            ['label' => 'Мои подписчики', 'badge' => \Yii::$app->user->identity->profile->follower_counter, 'icon' => 'file-code-o', 'url' => ['/profile/default/index', 'tab' => 'myfollowers']],
        ]
    ];

    $items[] = ['label' => 'Уведомления', 'icon' => 'file-code-o', 'url' => ['/notify/default/index']];
}


if (User::hasRole('Admin')) {

    $items[] = ['label' => 'Справочники', 'options' => ['class' => 'header']];
    $items[] = ['label' => 'Специализации', 'icon' => 'file-code-o', 'url' => ['/catalog/working']];
    $items[] = ['label' => 'Компании', 'icon' => 'file-code-o', 'url' => ['/company/default/index']];
    $items[] = ['label' => 'Заказы', 'icon' => 'file-code-o', 'url' => ['/order/default/index']];
    
    
    $items[] = ['label' => 'Пользователи', 'options' => ['class' => 'header']];
    
    $non = Yii::$app->db->createCommand('select count(*) from profile where is_verified=0')->queryScalar();
    $items[] = [
        'label' => 'Неподтвержденнные ', 
        'icon' => 'file-code-o', 
        'url' => ['/profile/admin/index'], 
        'badge' => ($non == 0) ? '' : $non        
    ];
    $items[] = ['label' => 'Пользователи', 'icon' => 'file-code-o', 'url' => ['/user-management/user/index']];
    $items[] = ['label' => 'Роли', 'icon' => 'file-code-o', 'url' => ['/user-management/role/index']];
    $items[] = ['label' => 'Права', 'icon' => 'file-code-o', 'url' => ['/user-management/permission/index']];
    $items[] = ['label' => 'Группы прав', 'icon' => 'file-code-o', 'url' => ['/user-management/auth-item-group/index']];
    $items[] = ['label' => 'История посещений', 'icon' => 'file-code-o', 'url' => ['/user-management/user-visit-log/index']];
    
    
    $items[] = ['label' => 'Menu Yii2', 'options' => ['class' => 'header']];
    $items[] = ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']];
    $items[] = ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']];
}

?>
        <?= dmstr\widgets\Menu::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                
                'items' => $items
            ]
        ) ?>

    </section>

</aside>
