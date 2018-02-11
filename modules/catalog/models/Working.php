<?php

namespace app\modules\catalog\models;

use Yii;
use yii\helpers\VarDumper;

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
    
    public static function loadItemsWithParentAsArray() {
        $result = [];
        $parents = \Yii::$app->db->createCommand('
            select * from working where parent_id = 0 order by title 
        ')->queryAll();
        
        $childrens = \Yii::$app->db->createCommand('
            select * from working where parent_id > 0 order by parent_id, title
        ')->queryAll();
        
        foreach ($parents as $p) {
            $result[$p['id']] = ['title' => $p['title'] ];
        }
        
        foreach ($childrens as $child) {           
            $result[ intval($child['parent_id']) ]['children'][] =  ['id' => $child['id'], 'title' => $child['title']];
        }
        
        $data = [];
        foreach ($result as $r) {
            if (isset($r['children'])) {
                foreach ($r['children'] as $c) {
                    $data[$c['id']] = ['content' => $r['title'] . ' / ' . $c['title'] ];
                }
            }
        }
        return $data;
    }
    
    public static function loadItemsWithParent() {
        $result = [];
        
        $selected = \Yii::$app->db->createCommand('
            select 
                working_id
            from 
                user_working
            where
                user_id=:user_id
        ',[
            ':user_id' => \Yii::$app->user->id
        ])->queryAll();
        
        $parents = \Yii::$app->db->createCommand('
            select * from working where parent_id = 0 order by title
        ')->queryAll();
        
        $childrens = \Yii::$app->db->createCommand('
            select * from working where parent_id > 0 order by parent_id, title
        ')->queryAll();
        
        foreach ($parents as $p) {
            $result[$p['id']] = ['title' => $p['title'] ];
        }
        
        foreach ($childrens as $child) {
            $result[ intval($child['parent_id']) ]['children'][] =  ['id' => $child['id'], 'title' => $child['title']];
        }
        
        // VarDumper::dump($result,10,true);
        // echo "<br><br>";
        $data = [];
        foreach ($result as $r) {
            if (isset($r['children'])) {
                $cArray = [];
                foreach ($r['children'] as $c) {
                    //VarDumper::dump($c,10,true);
                    //echo "<br><br>";
                    // $cArray[] = [$c['id'] => $c['title']];
                    
                    $data[$r['title']][$c['id']] = $c['title'];
                }
                //$data[$r['title']][] = $cArray;
            }
        }
        // VarDumper::dump($data,10,true);
        //  die;
        return $data;
    }
    
    public function getParentWorking() {
        return $this->hasOne(Working::className(), ['id' => 'parent_id']);
    }
    
    public function getChildrends() {
        return $this->hasMany(Working::className(), ['parent_id' => 'id']);
    }
}
