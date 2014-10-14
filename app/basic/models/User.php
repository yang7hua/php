<?php

namespace app\models;

use yii\web\IdentityInterface;

class User extends \Yii\base\Object implements IdentityInterface
{
	public $uid;
	public $username;
	public $password;
	public $salt;
	public $nickname;
	public $email;
	public $ip;
	public $phone;

	public static function findIdentity($uid)
	{
		return Users::findOne($uid);
	}

	public static function findIdentityByAccessToken($token, $type = null)
	{
		return Users::findOne(['password' => $token]);
	}

	public function getId()
	{
		return $this->uid;
	}

	public function getAuthKey()
	{
		return $this->authKey;
	}

	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	static function findByUsername($username)
	{
		$user = Users::findOne(['username'=>$username]);
		if ($user)
			return new static($user);
		return null;
	}

	static function createPassword($password, $salt='blog')
	{
		$salt = strlen($salt) > 4 ? substr($salt, 0, 4) : $salt; 
		$password = md5($password . $salt);
		return [
			'password'	=>	$password,
			'salt'	=>	$salt
		];
	}

	public function validatePassword($password)
	{
		return User::createPassword($password, $this->salt)['password'] == $this->password;
	}

}
