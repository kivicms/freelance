<?php 
namespace app\widgets\orderswidget;

use yii\base\Widget;
use app\modules\order\models\Order;

class OrdersWidget extends Widget {
    
    public $profile; // Profile
    
    public function run() {
        
        $models = Order::find()->where('user_id=:user_id AND is_archive=0',[
            ':user_id' => $this->profile->user_id            
        ])->orderBy('created_at desc')->all();
        return $this->render('index',[
            'models' => $models
        ]);
    }
}