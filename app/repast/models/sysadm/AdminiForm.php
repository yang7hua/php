<?php

namespace app\models\sysadm;

use app\models\sysadm\Admini;

class AdminiForm extends \app\models\ModelForm
{
	public $username;
	public $password;
	public $captcha;

	public function rules()
	{
		return [
			[['username', 'password', 'captcha'], 'required'],
			['captcha', 'captcha']
		];
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['login'] = ['username', 'password', 'captcha'];
		return $scenarios;
	}

	public function attributeLabels()
	{
		return [
			'username'	=>	'账号',
			'password'	=>	'密码',
			'captcha'	=>	'验证码'
		];
	}

	public function login()
	{
		if ($this->validate())
		{
			$result = Admini::login([
				'username'	=>	$this->username,
				'password'	=>	$this->password
			]);
			if (is_array($result))
			{
				$this->addError($result[0], $result[1]);
				return false;
			}
			return $result;
		}
	}
}
