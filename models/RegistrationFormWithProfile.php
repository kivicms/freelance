<?php

namespace app\models;


use webvimark\modules\UserManagement\models\forms\RegistrationForm;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use Yii;
use app\modules\profile\models\Profile;

class RegistrationFormWithProfile extends RegistrationForm
{
	public $title;
	public $phone;
	public $email;

	/**
	 * @return array
	 */
	public function rules()
	{
		return ArrayHelper::merge(parent::rules(), [
			[['title', 'phone', 'email', ], 'required'],
		    [['title', 'phone', 'email', ], 'string'],
		    [['title', 'phone', 'email', ], 'string', 'max' => 255],
		    [['title', 'phone', 'email', ], 'trim'],
		    [['title', 'phone', 'email', ], 'purgeXSS'],
		    
		    [['email'], 'email']
		]);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return ArrayHelper::merge(parent::attributeLabels(), [
			'title' => 'Наименование ООО или ИП',
			'phone' => 'Личный телефон',
		    'email' => 'Личный E-Mail'
		]);
	}


	/**
	 * Look in parent class for details
	 *
	 * @param User $user
	 */
	protected function saveProfile($user)
	{
		$model = new Profile();

		$model->user_id = $user->id;

		$model->title = $this->title;
		$model->email = $this->email;
		$model->phone = $this->phone;

		$model->save(false,['user_id', 'email', 'title', 'phone']);
		
/* 		Yii::$app->db->createCommand('insert into auth_assignment (item_name, user_id, created_at) values("company", :user_id, :time)',[
		    ':user_id' => $user->id,
		    ':time' => time()
		])->execute();  */
	}
}