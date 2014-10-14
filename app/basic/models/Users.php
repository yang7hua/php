<?php

namespace app\models;

use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
	public static function tableName()
	{
		return 'user';
	}

	public static function findByUsername($username)
	{
		return parent::findOne(['username'=>$username]);
	}
}
