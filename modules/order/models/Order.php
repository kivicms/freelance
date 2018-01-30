<?php

namespace app\modules\order\models;

use Yii;
use app\models\User;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property double $budget
 * @property int $budget_type
 * @property string $deadline
 * @property int $status Статус
 * @property int $is_archive В архиве
 * @property int $executor_id Исполнитель
 * @property int $view_counter
 * @property int $response_counter
 * @property string $money_type
 * @property string $tags
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $user
 * @property OrderWorking[] $orderWorkings
 */
class Order extends \yii\db\ActiveRecord
{
    
    public $money = [];
    
    const MONEY_CASH = 0;
    const MONEY_CACHLESS = 1;
    const MONEY_ELECTRONIC = 2;
    
    const BUDGET_PROJECT = 0;
    const BUDGET_HOUR = 1;
    const BUDGET_MONTH = 2;
    const BUDGET_1000 = 3;
    
    const ARCHIVE_NO = 0;
    const ARCHIVE_YES = 1;
    
    public static function itemAlias($type,$code=NULL) {
        $_items = [
            'MoneyType' => [
                self::MONEY_CASH => 'наличный расчет',
                self::MONEY_CACHLESS => 'безналичный расчет',
                self::MONEY_ELECTRONIC => 'электронные деньги'
            ],
            'BudgetType' => [
                self::BUDGET_PROJECT => 'За проект',
                self::BUDGET_HOUR => 'За месяц',
                self::BUDGET_MONTH => 'За месяц',
                self::BUDGET_1000 => 'За 1000 знаков',
            ],
            'Archive' => [
                self::ARCHIVE_NO => 'Нет',
                self::ARCHIVE_YES => 'Да'
            ]    
        ];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
            else
                return isset($_items[$type]) ? $_items[$type] : false;
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            'images' => [
                'class' => 'dvizh\gallery\behaviors\AttachImages',
                'mode' => 'gallery',
                'quality' => 60,
                'galleryId' => 'picture'
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'is_archive', 'executor_id','view_counter', 
                'response_counter',
                
                'created_at', 'updated_at', 'created_by', 'updated_by', 'budget_type'], 'integer'],
            [['description', 'tags','money_type'], 'string'],
            [['money'], 'safe'],
            [['budget'], 'number'],
            [['deadline'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->money_type = Json::encode($this->money);
            return true;
        }
        return false;
    }
    
    public function afterFind() {
        $this->money = Json::decode($this->money_type);
        return parent::afterFind();
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Заказчик',
            'title' => 'Наименование',
            'description' => 'Описание',
            'budget' => 'Бюджет',
            'budget_type' => 'за',
            'deadline' => 'Срок исполнения',
            'status' => 'Status',
            'is_archive' => 'В архиве',
            'executor_id' => 'Исполнитель',
            'view_counter' => 'Просмотров',
            'response_counter' => 'Откликов',
            'money' => 'Способ оплаты',            
            'tags' => 'Теги',
            'created_at' => 'Создано',
            'updated_at' => 'Отредактировано',
            'created_by' => 'Автор',
            'updated_by' => 'Редактор'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderWorkings()
    {
        return $this->hasMany(OrderWorking::className(), ['order_id' => 'id']);
    }
}
