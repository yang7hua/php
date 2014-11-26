<?php

class DepartmentForm extends ModelForm
{
	public static function fields()
	{
		return [
			'add'	=>	[
				'bid'	=>	[
					'label'	=>	'所属门店',
					'type'	=>	'select',
					'default'	=>	0,
					'options'	=>	(new Branch())->options()
				],
				'name'	=>	[
					'label'	=>	'部门名称',
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
			'edit'	=>	[
				'did'	=>	[
					'type'	=>	'hidden'
				],
				'bid'	=>	[
					'label'	=>	'所属门店',
					'type'	=>	'select',
					'default'	=>	0,
					'options'	=>	(new Branch())->options()
				],
				'name'	=>	[
					'label'	=>	'部门名称',
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
			]
		];
	}

	public function add()
	{
		return Department::add($this->data);
	}

	public function edit()
	{
		$id = $this->data['did'];
		unset($this->data['did']);
		return Department::edit($id, $this->data);
	}
}
