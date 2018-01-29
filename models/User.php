<?php
namespace app\models;

use webvimark\modules\UserManagement\models\User as WUser;
use app\models\Profile;

class User extends WUser {
    
    public function getProfile() {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }
}