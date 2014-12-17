<?php

namespace app\models;

class Model extends \yii\db\ActiveRecord
{
	/**
	 * 生成密码
	 */
	public static function password($password)
	{
		return \app\vendor\util\Func::password($password);
	}

	public static function equalPassword($password, $equal)
	{
		return self::password($password) == $equal;
	}
}
