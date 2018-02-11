<?php

namespace app\modules\catalog\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "user_working".
 *
 * @property int $id
 * @property int $user_id
 * @property int $working_id
 *
 * @property User $user
 * @property Working $working
 */
class UserWorking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_working';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'working_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'working_id' => 'Working ID',
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
    public function getWorking()
    {
        return $this->hasOne(Working::className(), ['id' => 'working_id']);
    }
}
