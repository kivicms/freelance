<?php 
namespace app\widgets\companysearchwidget;

use yii\base\Model;

class CompanySearchForm extends Model {
    public $cats = [];
    public $title;
    
    public function rules() {
        return [
            [['title'], 'string'],
            [['cats'], 'safe']
        ];
    }
    
    public function attributeLabels() {
        return [
            'title' => 'Наименование',
            'cats' => 'Категории'
        ];
    }
    
}