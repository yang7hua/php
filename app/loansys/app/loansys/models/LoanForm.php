<?php

class LoanForm extends ModelForm
{
	public static function fields()
	{
		return [
			'apply'	=>	[
				'uid'	=>	null,
				'amount'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
					]
				],
				'deadline'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
					]
				],
				'repay_method'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
					]
				],
				'use_type'	=>	[
					'validator'	=>	[
						'required'	=>	true,
						'number'	=>	1,
					]
				],
				'use_type_info'	=>	[
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'repay_source'	=>	[
					'validator'	=>	[
						'required'	=>	true,
					]
				],
			]
		];
	}

	//申请贷款
	public function apply()
	{
		return User::add($this->data, true);
	}

}
