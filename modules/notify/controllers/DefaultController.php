<?php

namespace app\modules\notify\controllers;

use Yii;
use app\modules\notify\models\Notify;
use app\modules\notify\models\NotifySearch;
use yii\web\NotFoundHttpException;
use app\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * DefaultController implements the CRUD actions for Notify model.
 */
class DefaultController extends BaseController
{

    public function actionListActive() {
        $data = [];
        $models = Notify::find()->where('to_user_id=:user_id AND status=0',[
            ':user_id' => \Yii::$app->user->id
        ])->orderBy('created_at desc')->all();
        $data['counter'] = count($models);
        $data['content'] = $this->renderAjax('list-active',[
            'models' => $models
        ]);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    /**
     * Lists all Notify models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notify model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 0) {
            $model->status = 1;
            $model->readed_time = time();
            $model->save();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Notify model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notify();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Notify model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Notify model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notify::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
