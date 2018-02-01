<?php 
namespace app\controllers;

use app\models\Profile;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use app\helpers\NotifyHelper;
use yii\helpers\Html;

class ProfileController extends BaseController {
    
    public function actionIndex($id = null) {
        return $this->render('index', [
            'model' => $this->findModel($id)
        ]);
    }
    
    public function actionUpdate($id = null) {
        $model = $this->findModel($id);
        
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            NotifyHelper::send(1, 
                'Пользователь ' . $model->fullCompanyName . ' изменил свои данные', 
                'Пользователь ' . Html::a($model->fullCompanyName,['/profile/index', 'id' => $model->user_id]) . ' изменил свои данные'
            );
            return $this->redirect(['index', 'id' => $model->user_id]);
        } else { 
            if ($model->hasErrors()) {
                \Yii::$app->session->setFlash('error', $model->getErrors());
            }
            return $this->render('update',[
            'model' => $model
            ]);
        }
    }
    
    protected function findModel($id)
    {
        if ($id == null) {
            if (($model = Profile::find()->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])->one()) !== null) {
                return $model;
            }
        } else {
            if (($model = Profile::find()->where('user_id=:user_id', [':user_id' => $id])->one()) !== null) {
                return $model;
            }
        }
        
        
        throw new NotFoundHttpException('Указанная страница не существует.');
    }
    
    public function getShortName() {
        
    }
}