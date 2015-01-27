<?php

class OperatorForm extends ModelForm
{
	public static function fields()
	{
		return [
			'add'	=>	[
				'oid'	=>	null,
				'bid'	=>	[
					'label'	=>	'所属分店',
					'type'	=>	'select',
					'inputOptions'	=>	[
					],
					'options'	=>	Branch::options(),
					'default'	=>	null,
					'validator'	=> [
						'required'	=> true,
					]	
				],
				'did'	=>	[
					'label'	=>	'所属部门',
					'type'	=>	'select',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-3'	
					],
					'options'	=>	Department::options(),
					'default'	=>	0,
					'validator'	=> [
						'required'	=> true,
					]	
				],
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
						'maxlength'	=>	20,
						'regex'	=>	'^[\\\\w_]+$',
						'remote'	=>	\Func\url('/operator/exist')
					],
					'remark'	=>	'用户名在3-20个字符之间, 字母数字或下划线组成',
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
			],
			
			'edit'	=>	[
				'oid'	=>	[
					'type'	=>	'hidden'
				],
				'username'	=>	[
					'label'	=>	'用户名',
					'type'	=>	'plain',
					'default'	=>	null
				],
				'bid'	=>	[
					'label'	=>	'所属分店',
					'type'	=>	'select',
					'inputOptions'	=>	[
					],
					'options'	=>	Branch::options(),
					'default'	=>	null,
					'validator'	=> [
						'required'	=> true,
					]	
				],
				'did'	=>	[
					'label'	=>	'所属部门',
					'type'	=>	'select',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-3'	
					],
					'options'	=>	Department::options(),
					'default'	=>	0,
					'validator'	=> [
						'required'	=> true,
					]	
				],
				'rid'	=>	[
					'label'	=>	'角色名称',
					'type'	=>	'select',
					'inputOptions'	=>	[
					],
					'options'	=>	Role::options(),
					'default'	=>	null,
					'validator'	=> [
						'required'	=> true,
					]	
				],
				'password'	=>	[
					'label'	=>	'密码',
					'type'	=>	'password',
					'inputOptions'	=>	[
					],
					'validator'	=>	[
						'minlength'	=>	6,
						'maxlength'	=>	12
					]
				],
				'repassword'	=>	[
					'label'	=>	'确认密码',
					'type'	=>	'password',
					'inputOptions'	=>	[
					],
					'validator'	=>	[
						'equalTo'	=>	'[name=password]'
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
