<?php

namespace app\modules\order\models;

use Yii;
use app\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_response".
 *
 * @property int $id
 * @property int $order_id Заказ
 * @property int $from_user_id От кого сообщение
 * @property string $response Текст комментария
 * @property int $created_at
 * @property int $updated_at
 * @property int $readed_time
 *
 * @property Order $order
 * @property User $toUser
 * @property User $fromUser
 */
class OrderResponse extends \yii\db\ActiveRecord
{
    
    public function behaviors() {
        return [
            TimestampBehavior::className()  
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'from_user_id', 'created_at', 'updated_at', 'readed_time'], 'integer'],
            [['response'], 'required'],
            [['response'], 'string'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'from_user_id' => 'From User ID',
            'response' => 'Текст отклика',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'readed_time' => 'Readed Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }
}
