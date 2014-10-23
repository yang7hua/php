<?php

namespace app\models\user;

use yii\base\Model;
use yii\web\UploadedFile;

class AvatarForm extends Model
{

	public $avatar;

	public function rules()
	{
		return [
			[['avatar'], 'file', 'extensions'=>'gif, jpg, jpeg, png']
		];
	}

	public function attributeLabels()
	{
		return [
			'avatar'	=>	'头像'
		];
	}
}
