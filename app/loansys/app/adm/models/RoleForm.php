<?php

class RoleForm extends ModelForm
{
	public static function fields()
	{
		return [
			'rid'	=>	null,
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
		];
	}

	public function add()
	{
		return Role::add($this->data);
	}
}
