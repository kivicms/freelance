<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\web\Response;
use yii\helpers\VarDumper;

class LoginController extends Controller {
    
    public function init() {
        $this->enableCsrfValidation = false;
    }
    
    public function behaviors() {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Access-Control-Allow-Origin' => ['http://localhost'],
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ];
    }
    public function actionIndex() {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (Yii::$app->getRequest()->getMethod() == 'OPTIONS') {
            return true;
        }
            
        $ret = [];
        $this->enableCsrfValidation = false;
        $user = User::find()->where('username=:username',[
            ':username' => Yii::$app->request->getBodyParam('username')
        ])->one();
        if ($user && $user->validatePassword(Yii::$app->request->getBodyParam('password')) ) {
             $ret = [
                'error' => false,
                'id' => $user->id, 
                'username' => $user->username,
                'access_token' => $user->auth_key,
                'avatar' => '1.gif', // $user->avatar,
//                'role' => $user->role,
//                'profileId' => $user->profile->id
            ];
         } else {
             $ret = [
                'error' => true,
                'errorMessage' => 'Неверный логин или пароль!'
            ]; 
        }        
        return $ret;
    }
}