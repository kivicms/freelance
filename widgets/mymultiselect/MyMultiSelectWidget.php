<?php 
namespace app\widgets\mymultiselect;

use yii\base\Widget;

class MyMultiSelectWidget extends Widget {
    
    public $profile;
    
    public function run() {
        
        return $this->render('index',[
            'profile' => $this->profile 
        ]);
    }
    
}