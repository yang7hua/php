<?php

namespace app\models;

use yii\base\Model;

class ProfileForm extends Model
{
	public $nickname;	
	public $avatar;

	public function attributeLabels()
	{
		return [
			'nickname'	=>	'昵称',
			'avatar'	=>	'头像'
		];
	}
}
