<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'search' => [
            'class' => 'himiklab\yii2\search\Search',
            'models' => [
                'app\modules\order\models\Order',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    'modules'=>[
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            'controllerNamespace'=>'vendor\webvimark\modules\UserManagement\controllers', // To prevent yii help from crashing
        ],
        'attachments' => [
            'class' => nemmo\attachments\Module::className(),
            'tempPath' => '@webroot/uploads/temp',
            'storePath' => '@webroot/uploads/store',
            'rules' => [ // Rules according to the FileValidator
                'maxFiles' => 10, // Allow to upload maximum 3 files, default to 3
                //'mimeTypes' => 'image/png', // Only png images
                'maxSize' => 1024 * 1024 * 10 // 1 MB
            ],
            'tableName' => '{{%attachments}}' // Optional, default to 'attach_file'
        ],
        'gallery' => [
            'class' => 'dvizh\gallery\Module',
            'imagesStorePath' => '@webroot/uploads/gallery/images/store', //path to origin images
            'imagesCachePath' => '@webroot/uploads/gallery/images/cache', //path to resized copies
            'graphicsLibrary' => 'GD',
            'placeHolderPath' => '@webroot/images/placeholder.png',
            // 'adminRoles' => ['administrator', 'admin', 'superadmin'],
        ],
    ],
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
