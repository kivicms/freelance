<?php 
namespace app\widgets;

use yii\base\Widget;

class AboutUsWidget extends Widget {
    public $model; // Profile
    
    public function run() {
        return $this->render('about-us-widget', [
            'model' => $this->model            
        ]);
    }
}