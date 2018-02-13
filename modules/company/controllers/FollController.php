<?php 
namespace app\modules\company\controllers;

use app\controllers\BaseController;
use app\modules\profile\models\Profile;
use yii\web\NotFoundHttpException;
use app\modules\company\models\Follower;
use yii\helpers\Url;

class FollController extends BaseController {
    
    // Подписаться-отписаться на компанию
    public function actionFollow($user_id, $follow=true) {
        $profile = $this->findModel($user_id);
        if ($follow) {
            $profile->follower_counter ++;
            $profile->save(false, ['follower_counter']);
            $f = new Follower();
            $f->user_id = $user_id;
            $f->follower_id = \Yii::$app->user->id;
            $f->save(false);
            $myProfile = $this->findModel(\Yii::$app->user->id);
            $myProfile->following_counter ++;
            $myProfile->save(false,['following_counter']);
        } else {
            $profile->follower_counter --;
            $profile->save(false, ['follower_counter']);
            Follower::deleteAll('user_id=:user_id AND follower_id=:follower_id',[
                ':user_id' => $user_id,
                ':follower_id' => \Yii::$app->user->id
            ]);
            $myProfile = $this->findModel(\Yii::$app->user->id);
            $myProfile->following_counter --;
            $myProfile->save(false,['following_counter']);
        }
        return $this->redirect(Url::previous());
    }
    

    
    protected function findModel($user_id) : Profile
    {
        if (($model = Profile::find()->where('user_id=:user_id', [':user_id' => $user_id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}