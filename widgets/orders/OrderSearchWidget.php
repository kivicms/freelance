<?php 
namespace app\widgets\orders;

use yii\base\Widget;

class OrderSearchWidget extends Widget {
    public $status = true;
    public $model;    
    public $searchStatus = 'SearchStatus';
    
    public function run() {
        return $this->render('order-search-widget',[
            'model' => $this->model,
            'status' => $this->status,
            'searchStatus' => $this->searchStatus
        ]);
    }
}