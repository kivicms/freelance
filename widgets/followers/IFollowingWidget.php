<?php 
namespace app\widgets\followers;

use yii\base\Widget;
use app\modules\profile\models\Profile;

class IFollowingWidget extends Widget {
    
    public function run() {
        $models = Profile::find()->leftJoin('follower as f', 'f.user_id = profile.user_id')->where('f.follower_id=:follower_id',[
            ':follower_id' => \Yii::$app->user->id
        ])->all();
        
        return $this->render('index',[
            'models' => $models
        ]);
    }
}