<?php

namespace app\modules\order\controllers;

use Yii;
use app\modules\order\models\Order;
use app\modules\order\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\BaseController;
use app\modules\order\models\OrderResponse;
use app\modules\profile\models\Profile;
use app\helpers\NotifyHelper;
use yii\helpers\Html;

/**
 * DefaultController implements the CRUD actions for Order model.
 */
class DefaultController extends BaseController
{

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionResponse() {
        $model = new OrderResponse();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $order = $this->findModel($model->order_id);
            $order->response_counter ++;
            $order->save(false, ['response_counter']);
        }
        return $this->redirect(['view', 'id' => $model->order->id]);
    }
    
    public function actionSetExecutor($id, $executor_id) {
        $model = $this->findModel($id);
        $model->executor_id = $executor_id;
        $model->is_archive = Order::ARCHIVE_YES;
        $model->save(false,['executor_id']);
        
        $profile = Profile::find()->where('user_id=:id',[':id' => $executor_id])->one();
        $profile->executed_orders ++;
        $profile->save(false, ['executed_orders']);
        
        NotifyHelper::send(
            $profile->user_id, 
            'Вы назначены исполнителем по заказу #' .  $model->id, 
            'Вы назначены исполнителем по заказу #' . Html::a($model->title, ['/order/default/view', 'id' => $model->id])
        );
        
        \Yii::$app->session->setFlash('info', 'Исполнитель успешно назначен. Заказ перенесен в архив.');
        return $this->redirect(['view', 'id' => $model->id]);
    }
    
    public function actionMy()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->my(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id !== \Yii::$app->user->id) {
            $model->updateCounters(['view_counter' => 1]);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Ваш заказ успешно опубликован!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Ваш заказ успешно обновлен!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
