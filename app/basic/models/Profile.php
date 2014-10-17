<?php

namespace app\models;

use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{

	public static function tableName()
	{
		return 'users';
	}

	public static function saveAvatar($avatar)
	{
		$uid = \Yii::$app->user->getId();
		$user = parent::findOne($uid);
		$user->avatar = $avatar;
		return $user->save();
	}

	public static function info()
	{
		return parent::findOne(\Yii::$app->user->getId());
	}
}
