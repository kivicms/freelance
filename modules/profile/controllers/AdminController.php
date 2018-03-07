<?php 
namespace app\modules\profile\controllers;

use app\controllers\BaseController;
use app\modules\profile\models\Profile;
use yii\web\NotFoundHttpException;
use app\helpers\NotifyHelper;
use yii\helpers\VarDumper;

class AdminController extends BaseController {
    
    public function actionIndex($id = null) {        
        if ($id) {
            $model = $this->findModel($id);
            $model->is_verified = Profile::PROFILE_VERIFIED_YES;
            $model->save(false, ['is_verified']);
            NotifyHelper::sendTemplate($model->user_id, 'UserVerified');
            // \Yii::$app->session->setFlash('success', 'Пользователь ' . $model->title . ' подтвержден. Уведомление успешно выслано.');
        }

        $models = Profile::find()->where('is_verified=:status', [':status' => Profile::PROFILE_VERIFIED_NO])->all();
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('index', [
                'models' => $models
            ]);
        }
        return $this->render('index', [
            'models' => $models
        ]); 
    }
    
    public function actionRefuse($id) {
        $model = $this->findModel($id);
        if (isset($_POST['Profile'])) {
            $model->refuse_content = $_POST['Profile']['refuse_content'];
            // VarDumper::dump($model,10,true);die;
            // $model->save(false,['refuse_content']);
            NotifyHelper::send($model->user_id, 'Верификация не пройдена!', $model->refuse_content);
        }
        $models = Profile::find()->where('is_verified=:status', [':status' => Profile::PROFILE_VERIFIED_NO])->all();
        return $this->render('index', [
            'models' => $models
        ]); 
    }
   
    public function actionView($id) {
        return $this->render('view',[
            'model' => $this->findModel($id)
        ]);   
    }
    
    protected function findModel($id) : Profile
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}