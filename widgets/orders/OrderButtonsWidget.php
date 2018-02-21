<?php 
namespace app\widgets\orders;

use yii\base\Widget;
use yii\helpers\Html;

class OrderButtonsWidget extends Widget {
    
    public $active = 'index';
    
    public function run() {
        return '<div class="btn-group">' . 
            Html::a('Все заказы', ['index'], ['class' => 'btn ' . ($this->active == 'index' ? 'btn-info' : 'btn-default')]) . ' ' . 
            Html::a('Я заказчик', ['i-customer'], ['class' => 'btn ' . ($this->active == 'i-customer' ? 'btn-info' : 'btn-default')]) . ' ' .
            Html::a('Я исполнитель', ['i-executor'], ['class' => 'btn ' . ($this->active == 'i-executor' ? 'btn-info' : 'btn-default')]) .
            Html::a('Мои отклики', ['my-response'], ['class' => 'btn ' . ($this->active == 'my-response' ? 'btn-info' : 'btn-default')]) .
            '</div>';
    }
}