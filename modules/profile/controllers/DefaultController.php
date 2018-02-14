<?php
namespace app\modules\profile\controllers;

use Yii;
use app\modules\profile\models\Profile;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use app\helpers\NotifyHelper;
use yii\helpers\Html;
use app\modules\catalog\models\Working;
use app\controllers\BaseController;
use app\modules\profile\models\ProfileSearch;
use yii\helpers\Json;

class DefaultController extends BaseController {
    
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
                'model' => $model,
                'availableWorking' => Working::loadItemsWithParentAsArray()
            ]);
        }
    }
    
    public function actionIFollowing() {
        /* $models = Profile::find()->leftJoin('follower as f', 'f.user_id = profile.user_id')->where('f.follower_id=:follower_id',[
         ':follower_id' => \Yii::$app->user->id
         ])->all();
         
         return $this->render('index',[
         'models' => $models
         ]); */
        
        $searchModel = new ProfileSearch();
        
        $dataProvider = $searchModel->searchIFollowing(Yii::$app->request->post());
        
        $html = $this->renderAjax('i-following', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        return Json::encode($html);
    }
    
    public function actionMyFollowers() {
        /* $models = Profile::find()->leftJoin('follower as f', 'f.follower_id = profile.user_id')->where('f.user_id=:user_id',[
         ':user_id' => \Yii::$app->user->id
         ])->all();
         
         return $this->render('index',[
         'models' => $models
         ]); */
        $searchModel = new ProfileSearch();
        
        $dataProvider = $searchModel->searchMyFollowers(Yii::$app->request->post());
        
        $html = $this->renderAjax('my-followers', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        return Json::encode($html);
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