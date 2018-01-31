<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "working".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 */
class Working extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->parent_id == null)
                $this->parent_id = 0;
            return true;
        }
        return false;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'title' => 'Наименование',
        ];
    }
    
    public function getParentWorking() {
        return $this->hasOne(Working::className(), ['id' => 'parent_id']);
    }
    
    public function getChildrends() {
        return $this->hasMany(Working::className(), ['parent_id' => 'id']);
    }
}
