<?php
use kartik\datecontrol\Module;
use webvimark\modules\UserManagement\components\UserAuthEvent;
use app\modules\profile\models\Profile;
use yii\helpers\VarDumper;
use app\helpers\NotifyHelper;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'RUSSIA NETWORK',
    'language' => 'ru-RU',
    'timeZone' =>  'Europe/Moscow',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'components' => [
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'pluralize' => true,
                    'controller' => [
                        'api/order'   
                    ]                    
                ],
                'POST logins' => 'login/index'
            ],
        ],
        
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                // ...
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'timeFormat' => 'HH:mm:ss',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'timeZone' => 'Europe/Moscow',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
        ],
        'view' => [
/*             'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ], */
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Dld_1x_VHoX6LD-MDNSv4s42S-UzKOSq',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ],
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => false,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                ]
            ],
            'on beforeSend' => function ($event) {
                header("Access-Control-Allow-Origin: *");
                $response = $event->sender;
                if ($response->data !== null && !empty(Yii::$app->request->get('suppress_response_code'))) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            }
        ],
            
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'user' => [
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',
            
            // Comment this if you don't want to record user logins
            'on afterLogin' => function ($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'db' => $db
        /*
     * 'urlManager' => [
     * 'enablePrettyUrl' => true,
     * 'showScriptName' => false,
     * 'rules' => [
     * ],
     * ],
     */
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'profile' => [
            'class' => 'app\modules\profile\Module',
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
        'report' => [            
            'class' => 'app\modules\report\Module',          
        ],
        'notify' => [  
            'class' => 'app\modules\notify\Module',            
        ],
        'catalog' => [
            'class' => 'app\modules\catalog\Module',
        ],
        'company' => [            
            'class' => 'app\modules\company\Module',
        ],
        'order' => [  
            'class' => 'app\modules\order\Module',            
        ],
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            
            'enableRegistration' => true,
            
            'registrationFormClass' => 'app\models\RegistrationFormWithProfile', 
            'rolesAfterRegistration' => ['company'],
            
            // Add regexp validation to passwords. Default pattern does not restrict user and can enter any set of characters.
            // The example below allows user to enter :
            // any set of characters
            // (?=\S{8,}): of at least length 8
            // (?=\S*[a-z]): containing at least one lowercase letter
            // (?=\S*[A-Z]): and at least one uppercase letter
            // (?=\S*[\d]): and at least one number
            // $: anchored to the end of the string
            
            
            'passwordRegexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^', 
            
            // Here you can set your handler to change layout for any controller or action
            // Tip: you can use this event in any module
            'on beforeAction' => function (yii\base\ActionEvent $event) {
                if ($event->action->uniqueId == 'user-management/auth/login') {
                    $event->action->controller->layout = '/main-login.php';
                }
                if ($event->action->uniqueId == 'user-management/auth/registration') {
                    $event->action->controller->layout = '/main-login.php';
                }
                ;
            },
            'on afterRegistration' => function(UserAuthEvent $event) {                
                //  Here you can do your own stuff like assign roles, send emails and so on
/*                 $p = new Profile();
                $p->user_id = $event->user->id;
                $p->save(false, ['user_id']);
                Yii::$app->db->createCommand('insert into auth_assignment (item_name, user_id, created_at) values("company", :user_id, :time)',[
                    ':user_id' => $event->user->id,
                    ':time' => time()
                ])->execute();     */
                NotifyHelper::send(1,
                    'Зарегистрирован новый пользователь ' . $event->user->username, '');
            },
        ],
        'gallery' => [
            'class' => 'dvizh\gallery\Module',
            'imagesStorePath' => '@webroot/uploads/gallery/images/store', //path to origin images
            'imagesCachePath' => '@webroot/uploads/gallery/images/cache', //path to resized copies
            'graphicsLibrary' => 'GD',
            'placeHolderPath' => '@webroot/images/placeholder.png',
            // 'adminRoles' => ['administrator', 'admin', 'superadmin'],
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
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',
            
            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd.MM.yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd.MM.yyyy hh:mm:ss a',
            ],
            
            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            
            // set your display timezone
            'displayTimezone' => 'Asia/Yekaterinburg',
            
            // set your timezone for date saved to db
            'saveTimezone' => 'Asia/Yekaterinburg',
            
            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
            
            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
                Module::FORMAT_DATETIME => [], // setup if needed
                Module::FORMAT_TIME => [], // setup if needed
            ],
            
            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings' => [
                Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker', // example
                    'options' => [
                        'dateFormat' => 'php:d.M.Y',
                        'options' => ['class'=>'form-control'],
                    ]
                ]
            ]
            // other settings
        ]
    ],
    'params' => $params
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '87.241.204.6'],
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '87.241.204.6'],
        'generators' => [ //here
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
    ];
}

return $config;
