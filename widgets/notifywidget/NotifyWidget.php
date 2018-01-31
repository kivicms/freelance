<?php 
namespace app\widgets\notifywidget;

use yii\base\Widget;
use app\modules\notify\models\Notify;

class NotifyWidget extends Widget {
    
    public function run() {
        $models = Notify::find()->where('to_user_id=:user_id AND status=0',[
            ':user_id' => \Yii::$app->user->id
        ])->orderBy('created_at desc')->all();
        
        return $this->render('index',[
            'models' => $models
        ]);
    }
}