<?php
namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;

class BaseApiController extends ActiveController
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authentificator' => [
                'class' => HttpBearerAuth::className(),
                'except' => ['options'],
                'optional' => ['tofile', 'print', 'upload'],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Access-Control-Allow-Origin' => ['*'],
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
            
        ]);
    }
}