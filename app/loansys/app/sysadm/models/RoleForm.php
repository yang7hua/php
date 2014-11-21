<?php

class RoleForm extends ModelForm
{
	public static function fields()
	{
		return [
		//添加角色
		'add'	=>	[
			'did'	=>	[
				'label'	=>	'部门名称',
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
			'name'	=>	[
				'label'	=>	'角色名称',
				'type'	=>	'text',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],	
				'validator'	=>	[
					'required'	=>	true,
					'minlength'	=>	2,
					'maxlength'	=>	10
				],
				'remark'	=>	'名称在2-10个字符之间'
			]
		],

		//编辑角色
		'edit'	=>	[
			'rid'	=>	[
				'type'	=>	'hidden'
			],
			'did'	=>	[
				'label'	=>	'部门名称',
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
			'name'	=>	[
				'label'	=>	'角色名称',
				'type'	=>	'text',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],	
				'validator'	=>	[
					'required'	=>	true,
					'minlength'	=>	2,
					'maxlength'	=>	10
				],
				'remark'	=>	'名称在2-10个字符之间'
			]
		],

		//角色授权
		'auth'	=>	[
			'rid'	=>	[
				'type'	=>	'hidden'
			],
			'auth'	=>	[
				'type'	=>	'checkbox',
			]
		]
		
		];
	}

	public function add()
	{
		return Role::add($this->data);
	}

	public function edit()
	{
		$rid = $this->data['rid'];
		unset($this->data['rid']);
		return Role::edit($rid, $this->data);
	}

	public function allot()
	{
		return $this->edit();
	}
}
