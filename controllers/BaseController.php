<?php
namespace app\controllers;

use yii\web\Controller;

class BaseController extends Controller
{

    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl'
            ]
        ];
    }
    
    public function init() {
        if (\Yii::$app->user->identity->profile->is_verified == 0) { 
            \Yii::$app->session->setFlash('warning', 'Ваша страничка проверяется. По окончанию проверки вы сможете принимать и выставлять заказы');
        }
    }
}