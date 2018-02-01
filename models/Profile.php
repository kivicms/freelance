<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $phone
 * @property string $www
 * @property int $type_of_legal Тип юр лица 0 - ООО, 1 ИП
 * @property string $title Наименование
 * @property string $description Описание
 * @property string $address_fact Фактический адрес
 * @property string $address_legal Юридический адрес
 * @property int $is_verified Проверено: 0 - нет, 1 - да
 * @property int $executed_orders 
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    const LEGAL_OOO = 0;
    const LEGAL_IP = 1;
    
    const PROFILE_VERIFIED_NO = 0;
    const PROFILE_VERIFIED_YES = 1;
    
    const SEX_WOMEN = 0;
    const SEX_MAN = 1;
    
    public static function itemAlias($type,$code=NULL) {
        $_items = [
            'Legal' => [
                self::LEGAL_OOO => 'Общество с ограниченной ответственностью',
                self::LEGAL_IP => 'Индивидуальный предприниматель',
            ],
            'Verified' => [
                self::PROFILE_VERIFIED_NO => 'Профиль не проверен',
                self::PROFILE_VERIFIED_YES => 'Профиль проверен'
            ],
            'Sex' => [
                self::SEX_MAN => 'Мужской',
                self::SEX_WOMEN => 'Женский'
            ]
        ];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
            else
                return isset($_items[$type]) ? $_items[$type] : false;
    }
    function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'images' => [
                'class' => 'dvizh\gallery\behaviors\AttachImages',
                'mode' => 'single', //'gallery',
                'quality' => 60,
                'galleryId' => 'picture'
            ],
            'fileBehavior' => [
                'class' => \nemmo\attachments\behaviors\FileBehavior::className()
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type_of_legal', 'is_verified', 'executed_orders', 'sex'], 'integer'],
            [['phone', 'title', 'description', 'address_fact', 'address_legal'], 'required'],
            [['description', 'www', 'lastname', 'firstname', 'middlename'], 'string'],
            [['www'], 'url'],
            [['phone'], 'string', 'max' => 20],
            [['title', 'address_fact', 'address_legal'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [ 
            'id' => 'ID',
            'user_id' => 'User ID',
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'middlename' => 'Отчество',
            'sex' => 'Пол',
            'www' => 'Сайт',
            'phone' => 'Телефон',
            'type_of_legal' => 'Тип ',
            'title' => 'Наименование',
            'description' => 'Описание',
            'address_fact' => 'Фактический адрес',
            'address_legal' => 'Юридический адрес',
            'is_verified' => 'Проверено',
            'executed_orders' => 'Выполнено заказов'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getFullFio() {
        return implode(' ', [$this->lastname, $this->firstname, $this->middlename]);
    }
    
    public function getShortFio() {
        return $this->lastname . ' ' . mb_substr($this->firstname,0,1) . '. ' . mb_substr($this->middlename,0,1) . '.';
    }
    
    public function getFullCompanyName() {
        if ($this->type_of_legal == self::LEGAL_OOO)
            return $this->title;
        else
            return $this->getFullFio();
    }
}
