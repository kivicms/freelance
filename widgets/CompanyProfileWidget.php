<?php 
namespace app\widgets;

use yii\base\Widget;

class CompanyProfileWidget extends Widget {
    public $model; // Profile
    
    public function run() {
        return $this->render('company-profile-widget', [
            'model' => $this->model            
        ]);
    }
}