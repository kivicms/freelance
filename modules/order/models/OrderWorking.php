<?php

namespace app\modules\order\models;

use Yii;
use app\modules\catalog\models\Working;

/**
 * This is the model class for table "order_working".
 *
 * @property int $id
 * @property int $order_id
 * @property int $working_id
 *
 * @property Order $order
 * @property Working $working
 */
class OrderWorking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_working';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'working_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['working_id'], 'exist', 'skipOnError' => true, 'targetClass' => Working::className(), 'targetAttribute' => ['working_id' => 'id']],
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
            'working_id' => 'Working ID',
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
    public function getWorking()
    {
        return $this->hasOne(Working::className(), ['id' => 'working_id']);
    }
}
