<?php 
namespace app\widgets\orders;

use yii\base\Widget;
use app\modules\order\models\Order;

/*
 * Виджет - я заказчик
 */
class ICustomerOrderWidget extends Widget {
    
    public function run() {
        
        $models = Order::find()->where('user_id=:user_id AND is_archive=0',[
            ':user_id' => \Yii::$app->user->id            
        ])->orderBy('created_at desc')->all();
        
        return $this->render('index',[
            'models' => $models
        ]);
    }
}