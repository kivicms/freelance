<?php 
namespace app\widgets\companysearchwidget;

use yii\base\Widget;

class CompanySearchWidget extends Widget {
    
    public function run() {
        $model = new CompanySearchForm();
        return $this->render('index', [
            'model' => $model 
        ]);
    }
}