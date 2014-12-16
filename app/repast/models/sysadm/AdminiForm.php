<?php

namespace app\models\sysadm;

class AdminiForm extends Model
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
}
