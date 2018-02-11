<?php 
namespace app\widgets\followers;

use yii\base\Widget;
use app\modules\profile\models\Profile;

class MyFollowersWidget extends Widget {
    
    public function run() {
        $models = Profile::find()->leftJoin('follower as f', 'f.follower_id = profile.user_id')->where('f.user_id=:user_id',[
            ':user_id' => \Yii::$app->user->id
        ])->all();
        
        return $this->render('index',[
           'models' => $models 
        ]);
    }
}