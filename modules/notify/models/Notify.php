<?php

namespace app\modules\notify\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "notify".
 *
 * @property int $id
 * @property int $to_user_id
 * @property string $title
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property int $status 0 непрочитано, 1 - прочитано
 * @property int $readed_time
 */
class Notify extends \yii\db\ActiveRecord
{
    
    public function behaviors(){
        return [
            TimestampBehavior::className()  
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notify';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['to_user_id', 'created_at', 'updated_at', 'status', 'readed_time'], 'integer'],
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to_user_id' => 'Кому',
            'title' => 'Наименование',
            'description' => 'Описание',
            'created_at' => 'Создано',
            'updated_at' => 'Updated At',
            'status' => 'Статус',
            'readed_time' => 'Прочитано в',
        ];
    }
}
