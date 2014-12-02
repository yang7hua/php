<?php

class LoanSketchForm extends ModelForm
{
	public static function fields()
	{
		return [
			'apply'	=>	[
				'uid'	=>	[
					'validator'	=>	[
						'required'	=>	1
					]
				],
				'loan_type'	=>	[
					'default'	=>	1
				],
				'use_type'	=>	[
					'validator'	=>	[
						'required'	=>	1
					]
				],
				'use_type_info'	=>	[
					'default'	=>	'',
					'validator'	=>	[
						'required'	=>	1
					]
				],
				'amount'	=>	[
					'validator'	=>	[
						'required'	=>	1
					]
				],
				'deadline'	=>	[
					'validator'	=>	[
						'required'	=>	1
					]
				],
				'deadline_type'	=>	[
					'default'	=>	'm'
				],
				'days'	=>	[
					'default'	=>  0	
				],
				'repay_method'	=>	[
					'default'	=>  'o',
					'validator'	=>	[
						'required'	=>	1
					]
				],
				'repay_source'	=>	[
					'default'	=>  ''	
				],
				'description'	=>	[
					'default'	=>  ''	
				],
				'status'	=>	[
					'default'	=>	0
				]
			]
		];
	}

	public function apply()
	{
		return LoanSketch::add($this->data, true);
	}
}
