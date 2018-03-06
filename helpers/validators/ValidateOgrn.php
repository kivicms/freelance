<?php
// OGRN | OGRNIP validator (13-digit for OGRN, 15-digit for OGRNIP)
//  in rules()   [['ogrn'], 'app\helpers\validators\ValidateOgrn'],
// for test purpose use fake OGRN \ OGRNIP number 1111111111110 | 311111111111115
namespace app\helpers\validators;

use yii\validators\Validator;

class ValidateOgrn extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $ogrn = $this->parseOgrn($model->$attribute);
        if ($ogrn['length'] !== 13 && $ogrn['length'] !== 15) {
            $this->addError($model, $attribute, 'Неверная длина ОГРН/ОГРНИП');
        }
        if ($ogrn['length'] === 13 && !in_array($ogrn['attrFlag'], ['1', '2', '3', '5']) ||
            $ogrn['length'] === 15 && !in_array($ogrn['attrFlag'], ['3', '4'])) {
                $this->addError($model, $attribute, 'Неверный признак отнесения ОГРН/ОГРНИП');
        }
        if ($ogrn['year'] < 2 || $ogrn['year'] > date('y')){
            $this->addError($model, $attribute, 'Неверный год регистрации ОГРН/ОГРНИП');
        }
        if ($ogrn['checksum'] !== $ogrn['realChecksum']){
            $this->addError($model, $attribute, 'Неверная контрольная сумма ОГРН/ОРГНИП');
        }
    }
    
    protected function parseOgrn($ogrn)
    {
        return [
            'length' => strlen($ogrn),
            'attrFlag' => (int) substr($ogrn, 0, 1),
            'year' => (int) substr($ogrn, 1, 2),
            'checksum' => (strlen($ogrn) === 13) ? (int) substr($ogrn, 12, 1) : (int) substr($ogrn, 14, 1),
            'realChecksum' => (strlen($ogrn) === 13) ? (int) substr((substr($ogrn, 0, 12) % 11), -1) :
                                                       (int) substr((substr($ogrn, 0, 14) % 13), -1),
        ];
    }
}