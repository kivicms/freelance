<?php

namespace app\modules\profile\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\catalog\models\Working;
use app\models\User;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $email
 * @property string $phone
 * @property string $www
 * @property int $type_of_legal Тип юр лица 0 - ООО, 1 ИП
 * @property string $inn
 * @property string $kpp
 * @property string $ogrn
 * @property string $ogrnip
 * @property string $position
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
    public $refuse_content;
    
    public $w_ids = [];
    
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
            'ShortLegal' => [
                self::LEGAL_OOO => 'ООО',
                self::LEGAL_IP => 'ИП',
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
            [['phone', 'title', 'email', 'inn', 'position'], 'required'],            
            [['description', 'www', 'lastname', 'firstname', 'middlename'], 'string'],
            [['www'], 'url', 'defaultScheme' => 'http'],
            [['w_ids', 'refuse_content'], 'safe'],
            [['phone'], 'string', 'max' => 20],
            [['position'], 'string', 'max' => 30],
            [['email'], 'email'],
            [['title', 'address_fact', 'address_legal'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['inn'], 'app\helpers\validators\ValidateInn'],
            
            [['kpp'], 'app\helpers\validators\ValidateKpp'],
            [['kpp'], 'required', 'when' => function($model) {
                    return ($model->type_of_legal == 0);
                }
            ],
            
            [['ogrn'], 'app\helpers\validators\ValidateOgrn'],
            [['ogrn'], 'required', 'when' => function($model) {
                return ($model->type_of_legal == 0);
            }
            ],
            
            [['ogrnip'], 'app\helpers\validators\ValidateOgrn'],
            [['ogrnip'], 'required', 'when' => function($model) {                
                    return ($model->type_of_legal == 1);
                }
            ],
            
        ];
    }
    
    public function afterFind() {
        parent::afterFind();
        $ids = \Yii::$app->db->createCommand('
            select working_id from user_working where user_id=:user_id
        ',[
            ':user_id' => $this->user_id
        ])->queryAll();
        
        $this->w_ids = array_column($ids, 'working_id');
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
            'email' => 'E-Mail',
            'sex' => 'Пол',
            'www' => 'Сайт',
            'phone' => 'Телефон',
            'type_of_legal' => 'Тип ',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'ogrn' => 'ОГРН',
            'ogrnip' => 'ОГРНИП',
            'position' => 'Должность',
            'title' => 'Наименование',
            'description' => 'Описание',
            'address_fact' => 'Фактический адрес',
            'address_legal' => 'Юридический адрес',
            'is_verified' => 'Проверено',
            'refuse_content' => 'Причина отказа',
            'executed_orders' => 'Выполнено заказов',
            'w_ids' => 'Категории',
            'fullFio' => 'Контактное лицо',
            'fullCompanyName' => 'Полное наименование компании',
            'workingsAsTitleArray' => 'Направления работы'
        ];
    }

        
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        \Yii::$app->db->createCommand('
                delete from user_working where user_id=:user_id
            ',[
                ':user_id' => $this->user_id
            ])->execute();
            
            if (is_array($this->w_ids)) {
                foreach ($this->w_ids as $w_id) {
                    \Yii::$app->db->createCommand('
                        insert into user_working (user_id, working_id) values (:user_id, :working_id)
                    ',[
                        ':user_id' => $this->user_id,
                        ':working_id' => $w_id
                    ])->execute();
                }
            }
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
    
    public function getWorkingsAsTitleArray() {
        $ret = [];
        $wss = $this->workings;
        foreach ($wss as $ws) {
            $ret[] = $ws->title;
        }
        return $ret;
    }
    
    public function getWorkingsArray() {
        $ret = [];
        $wss = $this->workings;
        foreach ($wss as $ws) {
            $ret[] = $ws->id;
        }
        return $ret;
    }
    
    public function getWorkings() {
        return $this->hasMany(Working::className(), ['id' => 'working_id'])->viaTable('user_working', ['user_id' => 'user_id']);
    }
}
