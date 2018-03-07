<?php
namespace app\modules\order\models;

use Yii;
use app\models\User;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Json;
use app\modules\profile\models\Profile;
use app\modules\catalog\models\Working;
use yii\web\Linkable;
use yii\web\Link;
use yii\helpers\Url;
use himiklab\yii2\search\behaviors\SearchBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property double $budget
 * @property int $valuta
 * @property int $budget_type
 * @property string $start
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
 * @property string $placement
 *
 * @property User $user
 * @property OrderWorking[] $orderWorkings
 */
class Order extends \yii\db\ActiveRecord implements Linkable
{

    public $money = [];

    public $w_ids = [];

    public $placements = [];

    const MONEY_CASH = 0;

    const MONEY_CACHLESS = 1;

    const MONEY_ELECTRONIC = 2;

    const BUDGET_PROJECT = 0;

    const BUDGET_HOUR = 1;

    const BUDGET_MONTH = 2;

    const BUDGET_1000 = 3;

    const BUDGET_UNIT = 4;

    const BUDGET_PIECE = 5;

    const ARCHIVE_NO = 0;

    const ARCHIVE_YES = 1;

    const STATUS_DRAFT = 0;

    const STATUS_PUBLISHED = 1;

    const STATUS_EXECUTED = 2;

    const STATUS_SUCCESS = 3;

    const STATUS_SUCCESS_ACCEPTED = 4;

    const STATUS_CANCELLED = 5;

    const VALUTA_RUB = 0;

    const VALUTA_USD = 1;

    const VALUTA_EUR = 2;

    const VALUTA_GBP = 3;

    const VALUTA_BTC = 4;

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Valuta' => [
                self::VALUTA_RUB => 'RUR',
                self::VALUTA_USD => '$',
                self::VALUTA_EUR => '&euro;',
                self::VALUTA_GBP => '&#163;',
                self::VALUTA_BTC => 'BTC'
            ],
            'MoneyType' => [
                self::MONEY_CASH => 'наличный расчет',
                self::MONEY_CACHLESS => 'безналичный расчет',
                self::MONEY_ELECTRONIC => 'электронные деньги'
            ],
            'BudgetType' => [
                self::BUDGET_PROJECT => 'Проект',
                self::BUDGET_HOUR => 'Час',
                self::BUDGET_MONTH => 'Месяц',
                self::BUDGET_1000 => '1000 знаков',
                self::BUDGET_UNIT => 'Единица',
                self::BUDGET_PIECE => 'Штука'
            ],
            'Archive' => [
                self::ARCHIVE_NO => 'Нет',
                self::ARCHIVE_YES => 'Да'
            ],
            'Status' => [
                self::STATUS_DRAFT => 'Черновик',
                self::STATUS_PUBLISHED => 'Опубликован',
                self::STATUS_EXECUTED => 'В работе',
                self::STATUS_SUCCESS => 'Выполнен',
                self::STATUS_SUCCESS_ACCEPTED => 'Выполнение подтверждено',
                self::STATUS_CANCELLED => 'Отменен'
            ],
            'ShortStatus' => [
                self::STATUS_DRAFT => 'Черновик',
                self::STATUS_PUBLISHED => 'Опубликован'
            ],
            'SearchStatus' => [
                self::STATUS_PUBLISHED => 'Опубликован',
                self::STATUS_EXECUTED => 'В работе',
                self::STATUS_SUCCESS => 'Выполнен',
                self::STATUS_SUCCESS_ACCEPTED => 'Выполнение подтверждено',
                self::STATUS_CANCELLED => 'Отменен'
            ],
            'SearchStatusExecutor' => [
                self::STATUS_EXECUTED => 'В работе',
                self::STATUS_SUCCESS => 'Выполнен',
                self::STATUS_SUCCESS_ACCEPTED => 'Выполнение подтверждено',
                self::STATUS_CANCELLED => 'Отменен'
            ],
            'SearchStatusCustomer' => [
                self::STATUS_DRAFT => 'Черновик',
                self::STATUS_PUBLISHED => 'Опубликован',
                self::STATUS_EXECUTED => 'В работе',
                self::STATUS_SUCCESS => 'Выполнен',
                self::STATUS_SUCCESS_ACCEPTED => 'Выполнение подтверждено',
                self::STATUS_CANCELLED => 'Отменен'
            ]
        
        ];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to([
                'api/order/view',
                'id' => $this->id
            ], true)
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            'images' => [
                'class' => 'dvizh\gallery\behaviors\AttachImages',
                'mode' => 'gallery',
                'quality' => 60,
                'galleryId' => 'picture'
            ],
            'fileBehavior' => [
                'class' => \nemmo\attachments\behaviors\FileBehavior::className()
            ],
            'search' => [
                'class' => SearchBehavior::className(),
                'searchScope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select([
                        'title',
                        'description',
                        'id'
                    ]);
                    // $model->andWhere(['indexed' => true]);
                },
                'searchFields' => function ($model) {
                    /** @var self $model */
                    return [
                        [
                            'name' => 'title',
                            'value' => $model->title
                        ],
                        [
                            'name' => 'description',
                            'value' => strip_tags($model->description)
                        ],
                        [
                            'name' => 'url',
                            'value' => '/order/default/view' . $model->id,
                            'type' => SearchBehavior::FIELD_KEYWORD
                        ]
                        // ['name' => 'model', 'value' => 'page', 'type' => SearchBehavior::FIELD_UNSTORED],
                    ];
                }
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function rules()
    {
        return [
            [
                [
                    'title',
                    'description',
                    'budget',
                    'valuta',
                    'money',
                    'placements',
                    'w_ids'
                ],
                'required'
            ],
            [
                [
                    'user_id',
                    'status',
                    'is_archive',
                    'executor_id',
                    'view_counter',
                    'response_counter',
                    
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by',
                    'valuta',
                    'budget_type'
                ],
                'integer'
            ],
            [
                [
                    'description',
                    'tags',
                    'money_type',
                    'placement'
                ],
                'string'
            ],
            [
                [
                    'money'
                ],
                'safe'
            ],
            [
                [
                    'w_ids'
                ],
                'safe'
            ],
            [
                [
                    'placements'
                ],
                'safe'
            ],
            [
                [
                    'budget'
                ],
                'number'
            ],
            [
                [
                    'start',
                    'deadline'
                ],
                'safe'
            ],
            [
                [
                    'title'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'user_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => [
                    'user_id' => 'id'
                ]
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->money_type = Json::encode($this->money);
            $this->placement = Json::encode($this->placements);
            // echo "here!!!!!!!!!!!!!!!<br><br><br><br>";
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveWorkings();
        $this->updateOrder();
    }

    private function saveWorkings()
    {
        \Yii::$app->db->createCommand('
                delete from order_working where order_id=:order_id
            ', [
            ':order_id' => $this->id
        ])->execute();
        // VarDumper::dump($this->w_ids,10,true);die;
        if (is_array($this->w_ids)) {
//            VarDumper::dump($this->w_ids, 10, true);
            foreach ($this->w_ids as $w_id) {
                \Yii::$app->db->createCommand('
                        insert into order_working (order_id, working_id) values (:order_id, :working_id)
                    ', [
                    ':order_id' => $this->id,
                    ':working_id' => $w_id
                ])->execute();
            }
        }
    }

    private function updateOrder()
    {
        $activeOrders = \Yii::$app->db->createCommand('
            select
                count(*)
            from
                `order`
            where
                user_id=:user_id  AND is_archive=0', [
            ':user_id' => \Yii::$app->user->id
        ])->queryScalar();
        
        $allOrders = \Yii::$app->db->createCommand('
            select
                count(*)
            from
                `order`
            where
                user_id=:user_id', [
            ':user_id' => \Yii::$app->user->id
        ])->queryScalar();
        
        \Yii::$app->db->createCommand('
            update 
                profile 
            set 
                order_actual_counter=:actual,
                order_placed_counter=:all
            where
                user_id=:user_id
        ', [
            ':actual' => $activeOrders,
            ':all' => $allOrders,
            ':user_id' => $this->user_id
        ])->execute();
    }

    public function afterFind()
    {
        $this->money = Json::decode($this->money_type);
        $this->placements = Json::decode($this->placement);
        
        $ids = \Yii::$app->db->createCommand('
            select working_id from order_working where order_id=:order_id
        ', [
            ':order_id' => $this->id
        ])->queryAll();
        
        $this->w_ids = array_column($ids, 'working_id');
        
        return parent::afterFind();
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Заказчик',
            'title' => 'Наименование',
            'description' => 'Описание',
            'budget' => 'Бюджет',
            'valuta' => 'Валюта',
            'budget_type' => 'Ед. изм.',
            'start' => 'Дата начала',
            'deadline' => 'Срок исполнения',
            'status' => 'Статус',
            'is_archive' => 'В архиве',
            'executor_id' => 'Исполнитель',
            'view_counter' => 'Просмотров',
            'response_counter' => 'Откликов',
            'money' => 'Способ оплаты',
            'tags' => 'Теги',
            'created_at' => 'Создано',
            'updated_at' => 'Отредактировано',
            'created_by' => 'Автор',
            'updated_by' => 'Редактор',
            'placement' => 'Местоположение',
            'w_ids' => 'Категории',
            'placements' => 'Местоположения'
        ];
    }

    public function attributeHints()
    {
        return [
            'placement' => 'Через запятую'
        ];
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), [
            'user_id' => 'user_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'user_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderWorkings()
    {
        return $this->hasMany(OrderWorking::className(), [
            'order_id' => 'id'
        ]);
    }

    public function getMoneyTypesAsArray()
    {
        $ret = [];
        if (is_array($this->money)) {
            foreach ($this->money as $m) {
                $ret[] = self::itemAlias('MoneyType', $m);
            }
        }
        return $ret;
    }

    public function getWorkingsAsTitleArray()
    {
        $ret = [];
        $wss = $this->workings;
        foreach ($wss as $ws) {
            $ret[] = $ws->title;
        }
        return $ret;
    }

    public function getWorkings()
    {
        return $this->hasMany(Working::className(), [
            'id' => 'working_id'
        ])->viaTable('order_working', [
            'order_id' => 'id'
        ]);
    }
}
