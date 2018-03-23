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
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSearch($q = '')
    {
        /** @var \himiklab\yii2\search\Search $search */
        $search = Yii::$app->search;
        $searchData = $search->find($q); // Search by full index.
        //$searchData = $search->find($q, ['model' => 'page']); // Search by index provided only by model `page`.
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $searchData['results'],
            'pagination' => ['pageSize' => 10],
        ]);
        
        return $this->render('found',[
            'hits' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
            'query' => $searchData['query']
        ]);
    }
    
    public function actionICustomer()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchICustomer(Yii::$app->request->post());
        
        return $this->render('i-customer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIExecutor()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchIExecutor(Yii::$app->request->post());
        
        return $this->render('i-executor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionMyResponse() {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchMyResposne(Yii::$app->request->post());
        
        return $this->render('my-response', [
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
        NotifyHelper::send(
            $model->order->profile->user_id, 
            'Вам поступило новое предложение по заказу' , 
            'Вам поступило новое предложение по заказу ' . Html::a($model->order->title,['/order/default/view', 'id' => $model->order_id]) );
        return $this->redirect(['view', 'id' => $model->order->id]);
    }
    
    public function actionSetExecutor($id, $executor_id) {
        $model = $this->findModel($id);
        $model->executor_id = $executor_id;
        $model->status = Order::STATUS_EXECUTED;
        $model->save(false,['executor_id', 'status']);
        
        $profile = Profile::find()->where('user_id=:id',[':id' => $executor_id])->one();
        $profile->executed_orders ++;
        $profile->save(false, ['executed_orders']);
        
        NotifyHelper::send(
            $profile->user_id, 
            'Вы назначены исполнителем по заказу #' .  $model->id, 
            'Вы назначены исполнителем по заказу #' . Html::a($model->title, ['/order/default/view', 'id' => $model->id])
        );
        
        \Yii::$app->session->setFlash('info', 'Исполнитель успешно назначен.');
        return $this->redirect(['view', 'id' => $model->id]);
    }
    
    public function actionSuccess($id) {
        $model = $this->findModel($id);
        if ($model->executor_id != \Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            $model->status = Order::STATUS_SUCCESS;
            $model->save(false,['status']);
            NotifyHelper::send(
                $model->user_id,
                'Исполнитель уведомляет о исполнении заказа ' .  $model->title,
                'Исполнитель уведомляет о исполнении заказа ' . Html::a($model->title, ['/order/default/view', 'id' => $model->id])
            );
            \Yii::$app->session->setFlash('info', 'Уведомление о исполнении отправлено заказчику.');
        }
        return $this->redirect(Url::previous());
    }
    
    public function actionSuccessAccept($id) {
        $model = $this->findModel($id);
        if ($model->user_id != \Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            $model->status = Order::STATUS_SUCCESS_ACCEPTED;
            $model->is_archive = Order::ARCHIVE_YES;
            $model->save(false,['status', 'is_archive']);
            NotifyHelper::send(
                $model->executor_id,
                'Заказчик подтвердил исполнении заказа ' .  $model->title,
                'Заказчик подтвердил исполнении заказа ' . Html::a($model->title, ['/order/default/view', 'id' => $model->id])
                );
            \Yii::$app->session->setFlash('info', 'Уведомление о исполнении отправлено исполнителю. Заказ перемещен в архив.');
        }
        return $this->redirect(Url::previous());
    }
    
    public function actionValidate() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            
            $model = new Order();
            
            if ($model->load(Yii::$app->request->post())) {
                if ($errors = ActiveForm::validate($model)) {                    
                    return $errors;
                } else {
                    return true;
                }
            }
        }
    }
    
    public function actionValidateResponse() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            
            $model = new OrderResponse();
            
            if ($model->load(Yii::$app->request->post())) {
                if ($errors = ActiveForm::validate($model)) {                    
                    return $errors;
                } else {
                    return true;
                }
            }
        }
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
        if ($model->hasErrors()) {
            \Yii::$app->session->setFlash('error', Json::encode($model->getErrors()));
        }
        // VarDumper::dump($model,19,true);die;
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
