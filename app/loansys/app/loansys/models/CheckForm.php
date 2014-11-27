<?php

class CheckForm extends ModelForm
{
	public static function fields()
	{
		return [
			'visit'	=>	[
				'oid'	=>	null,
				'addtime'	=>	null,
				'uid'	=>	[
					'type'	=>	'hidden'
				],
				'visit_address'	=>	[
					'label'	=>	'外访公司地址',
					'type'	=>	'input',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true
					]
				],
				'license_compay_address'	=>	[
					'label'	=>	'',
					'type'	=>	'radio',
					'default'	=>	'0',
					'options'	=>	[
						['value'=>0, 'text'=>'license_compay_address']
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'debt_prove'	=>	[
					'label'	=>	'证明方式',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'debt_month_repay'	=>	[
					'label'	=>	'每月还款金额',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'debt_info'	=>	[
					'label'	=>	'预期情况说明',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'debt_car_info'	=>	[
					'label'	=>	'按揭车还款情况',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'info_base'	=>	[
					'label'	=>	'基本情况说明',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'info_income'	=>	[
					'label'	=>	'收入情况说明',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'use_info'	=>	[
					'label'	=>	'借款用途说明',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'repay_source'	=>	[
					'label'	=>	'还款来源核实',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
			]
		];
	}

	public function face()
	{
		return (new UserInfo())->add($this->data);
	}
}
