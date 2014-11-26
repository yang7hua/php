<?php

class BranchForm extends ModelForm
{
	public static function fields()
	{
		return [
			'add'	=>	[
				'name'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'minlength'	=>	2,
						'maxlength'	=>	10
					],
				],
				'province'	=>	[
					'default'	=>	0	
				],
				'city'	=>	[
					'default'	=>	0	
				],
			],
			'edit'	=>	[
				'bid'	=>	null,
				'name'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'minlength'	=>	2,
						'maxlength'	=>	10
					],
				],
				'province'	=>	[
					'default'	=>	0	
				],
				'city'	=>	[
					'default'	=>	0	
				],
			]
		];
	}

	public function add()
	{
		return Branch::add($this->data);
	}

	public function edit()
	{
		$id = $this->data['bid'];
		unset($this->data['bid']);
		return Branch::editById($id, $this->data);
	}
}
