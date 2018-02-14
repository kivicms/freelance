<?php 
namespace app\modules\profile\controllers;

use app\controllers\BaseController;
use app\modules\profile\models\Profile;
use yii\web\NotFoundHttpException;

class AdminController extends BaseController {
    
    public function actionIndex() {
        
        return $this->render('index', [
            'models' => Profile::find()->where('is_verified=:status', [':status' => Profile::PROFILE_VERIFIED_NO])->all()
        ]); 
    }
    
    public function actionView($id) {
        return $this->render('view',[
            'model' => $this->findModel($id)
        ]);   
    }
    
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}