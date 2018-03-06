<?php
// KPP validator (9-digits)
//  in rules()   [['kpp'], 'app\components\validators\validateKpp'],
// for test purpose use fake INN number 1234567894 or 123456789110
namespace app\helpers\validators;

use yii\validators\Validator;

class ValidateKpp extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $kpp = $model->$attribute;
        $len = strlen($kpp);
        if ($len !== 9) {
            $this->addError($model, $attribute, 'Неверная длина КПП');
        }
    }
}