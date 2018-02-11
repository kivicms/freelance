<?php

namespace app\modules\company\models;

use Yii;
use app\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "follower".
 *
 * @property int $id
 * @property int $user_id Автор
 * @property int $follower_id Айди подписчика
 * @property int $created_at Создано
 * @property int $updated_at Исправлено
 *
 * @property User $user
 * @property User $follower
 */
class Follower extends \yii\db\ActiveRecord
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
        return 'follower';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'follower_id', 'created_at', 'updated_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['follower_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Автор',
            'follower_id' => 'Айди подписчика',
            'created_at' => 'Создано',
            'updated_at' => 'Исправлено',
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
    public function getFollower()
    {
        return $this->hasOne(User::className(), ['id' => 'follower_id']);
    }
}
