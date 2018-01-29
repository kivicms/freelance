<?php 
namespace app\controllers;

use app\models\Profile;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class ProfileController extends BaseController {
    
    public function actionIndex($id = null) {
        return $this->render('index', [
            'model' => $this->findModel($id)
        ]);
    }
    
    public function actionUpdate($id = null) {
        $model = $this->findModel($id);
        
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
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