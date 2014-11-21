<?php

class OperatorForm extends ModelForm
{
	public static function fields()
	{
		return [
		//用于登录
		'login'	=>	[
			'username'	=>	[
				'label'	=>	'用户名',
				'type'	=>	'text',
				'validator'	=>	[
					'required'	=>	true
				]
			],
			'password'	=>	[
				'label'	=>	'密码',
				'type'	=>	'password',
				'validator'	=>	[
					'required'	=>	true
				]
			]
		]

		];
	}

	public function add()
	{
		return Operator::add($this->data);
	}

	public function edit()
	{
		$oid = $this->data['oid'];
		unset($this->data['oid']);
		return Operator::edit($oid, $this->data);
	}

	public function login()
	{
		return Operator::login($this->data);
	}
}
