<?php 
namespace app\widgets\responseorder;

use Yii;
use yii\base\Widget;
use app\modules\order\models\OrderResponse;

class ResponseOrderWidget extends Widget {
    
    public $order;
    
    public function run() {
        
        if ($this->order->user_id == Yii::$app->user->id) {
            $models = OrderResponse::find()->where('order_id=:order_id',[
                ':order_id' => $this->order->id,
            ])->orderBy('created_at asc')->all();
            
            return $this->render('my-order', [
                'models' => $models,
                'order' => $this->order
            ]);
            
        } else {
            $response = new OrderResponse();
            $response->order_id = $this->order->id;
            $response->from_user_id = \Yii::$app->user->id;
            
            $model = OrderResponse::find()->where('order_id=:order_id AND from_user_id=:user_id',[
                ':order_id' => $this->order->id,
                ':user_id' => \Yii::$app->user->id
            ])->orderBy('created_at asc')->one();
            
            return $this->render('index', [
                'order' => $this->order,
                'response' => $response,
                'model' => $model
            ]);
        }
    }
}