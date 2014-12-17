<?php

namespace app\models\sysadm;

class Admini extends \app\models\Model 
{
	public static function login(array $data)
	{
		$admini = Admini::findOne([
			'username'	=>	$data['username']
		]);
		if (!$admini)
			return ['username', '账号不存在'];

		if (!parent::equalPassword($data['password'], $admini->password))
			return ['password', '密码不正确'];

		return $admini;
	}
}
