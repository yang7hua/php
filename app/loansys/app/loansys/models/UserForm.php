<?php

class UserForm extends ModelForm
{
	public static function fields()
	{
		return [
			'apply'	=>	[
				'oid'	=>	[],
				'bid'	=>	[],
				'realname'	=>	[
					'validator'	=>	[
						'required'	=>	true
					]
				],
				'idcard'	=>	[
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'idcard_province'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
						'length'	=>	6
					]
				],
				'idcard_city'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
						'length'	=>	6
					]
				],
				'province'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
						'length'	=>	6
					]
				],
				'city'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
						'length'	=>	6
					]
				],
				'address'	=>	[
					'validator'	=>	[
						'minlength'	=>	6,
						'maxlength'	=>	50
					]
				],
				'marriage'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
					],
					'default'	=>	0
				],
				'mobile'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'regex'	=>	'^([\\d]{11};?)+$'	
					]
				],
				'spouse_name'	=>	[
					'default'	=>	''
				],
				'spouse_mobile'	=>	[
					'default'	=>	'',
				],
				'spouse_idcard'	=>	[
					'default'	=>	'',
				],
				'spouse_info'	=>	[
					'default'	=>	'',
				],
				'spouse_assure'	=>	[
					'default'	=>	0,
				],
				'have_child'	=>	[
					'default'	=>	0,
				],
				'child_info'	=>	[
					'default'	=>	'',
				],
				'info'	=>	[
					'default'	=>	'',
				],
				'gender'	=>	[
					'default'	=>	0	
				],
				'birthdate'	=>	[
					'default'	=>	0	
				],
				'contact_info'	=>	[
					'default'	=>	''
				],
			]
		];
	}

	public function apply($uid)
	{
		return User::add($uid, $this->data, true);
	}

}
