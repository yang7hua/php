<?php

namespace app\models\user;

use yii\base\Model;
use yii\db\ActiveRecord;

class UserForm extends Model
{
	private $_user = null;

	public $username;
	public $password;
	public $confirmPassword;
	public $verifyCode;

	public function rules()
	{
		return [
			[['username', 'password', 'verifyCode'], 'required'],
			['username', 'string', 'min'=>6, 'max'=>10, 'message'=>'用户名需在6-10个字符之间', 'on'=>'reg'],
			['username', 'uniquedUsername', 'on'=>'reg'],
			['password', 'validatePassword', 'on'=>'login'],
			[['confirmPassword'], 'required', 'on'=>'reg'],
			['confirmPassword', 'validateConfirmPassword'],
			['verifyCode', 'captcha', 'message'=>'验证码不正确']
		];
	}

	public function uniquedUsername($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = User::findByUsername($this->username);
			if ($user) {
				$this->addError($attribute, '该用户名已存在');
			}
		}
	}


	//校验登录密码是否正确
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, '用户名或密码不正确.');
			}
		}
	}

	//确认密码
	public function validateConfirmPassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->password != $this->confirmPassword)
				$this->addError($attribute, '两次密码输入不一致');
		}
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['login']	=	['username', 'password', 'verifyCode'];	
		$scenarios['reg']	=	['username', 'password', 'verifyCode', 'confirmPassword'];
		return $scenarios;
	}	

	public function attributeLabels()
	{
		return [
			'username'	=>	'用户名',
			'password'	=>	'密码',
			'confirmPassword'	=>	'确认密码',
			'verifyCode'	=>	'验证码'		
		];
	}

	public function login()
	{
		if ($this->validate()) {
			return \Yii::$app->user->login($this->getUser());
		}
		return false;
	}

	public function reg()
	{
		if ($this->validate()) {
			$user = new User();
			$user->username = $this->username;
			$password = User::createPassword($this->password);
			$user->password = $password['password'];
			$user->salt = $password['salt'];
			return $user->insert();
		} 
		return false;
	}

	public function getUser()
	{
		if (!$this->_user)
			$this->_user = User::findByUsername($this->username);
		return $this->_user;
	}
}
