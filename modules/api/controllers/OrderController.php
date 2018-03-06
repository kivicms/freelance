<?php 
namespace app\modules\api\controllers;

use app\controllers\BaseApiController;
use app\modules\order\models\OrderSearch;

class OrderController extends BaseApiController {
    public $modelClass = 'app\modules\order\models\Order';
    
    public function actions() {
        
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }
    
    public function prepareDataProvider() {
        
        $searchModel = new OrderSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
    
}