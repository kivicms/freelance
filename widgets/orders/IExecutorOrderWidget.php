<?php 
namespace app\widgets\orders;

use yii\base\Widget;
use app\modules\order\models\Order;

/*
 * Виджет - я исполнитель
 */
class IExecutorOrderWidget extends Widget {
    
    public function run() {
        
        $models = Order::find()->where('executor_id=:executor_id AND is_archive=0',[
            ':executor_id' => \Yii::$app->user->id            
        ])->orderBy('created_at desc')->all();
        
        return $this->render('index',[
            'models' => $models
        ]);
    }
}