<?php

class OperatorForm extends ModelForm
{
	public static function fields()
	{
		return [
			'oid'	=>	null,
			'rid'	=>	[
				'label'	=>	'角色名称',
				'type'	=>	'select',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'	
				],
				'options'	=>	Role::options(),
				'default'	=>	0,
				'validator'	=> [
					'required'	=> true,
				]	
			],
			'username'	=>	[
				'label'	=>	'用户名',
				'type'	=>	'text',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],	
				'validator'	=>	[
					'required'	=>	true,
					'minlength'	=>	3,
					'maxlength'	=>	10,
					'regex'	=>	'^[\\\\w_]+$',
					'remote'	=>	'/adm/operator/exist'
				],
				'remark'	=>	'用户名在3-10个字符之间, 字母数字或下划线组成',
				'remarkOptions'	=>	[
					'class'	=>	'col-lg-4'
				]
			],
			'password'	=>	[
				'label'	=>	'密码',
				'type'	=>	'password',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],
				'validator'	=>	[
					'required'	=>	true,
					'minlength'	=>	6,
					'maxlength'	=>	12
				]
			],
			'repassword'	=>	[
				'label'	=>	'确认密码',
				'type'	=>	'password',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],
				'validator'	=>	[
					'required'	=>	true,
					'equalTo'	=>	'[name=password]'
				]
			]
		];
	}

	public function add()
	{
		return Operator::add($this->data);
	}
}
