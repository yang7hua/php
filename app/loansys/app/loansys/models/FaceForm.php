<?php

class FaceForm extends ModelForm
{
	public static function fields()
	{
		return [
			'face'	=>	[
				'oid'	=>	null,
				'loan_type'	=>	[
					'label'	=>	'贷款方式',
					'type'	=>	'radio',
					'default'	=>	'1',
					'options'	=>	\App\Config\Loan::toOptions(\App\Config\Loan::loanType())
				],
				'bigger'	=>	[
					'label'	=>	'是否放大',
					'type'	=>	'checkbox',
					'default'	=>	0,
					'options'	=>	[
						['value'=>1, 'text'=>'是']
					]
				],
				'debt_amount'	=>	[
					'label'	=>	'借款人及配偶负债',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
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
					'label'	=>	'逾期情况说明',
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
					'label'	=>	'车辆情况说明',
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
					'label'	=>	'借款人及配偶收入说明',
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
					'label'	=>	'借款用途',
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
					'label'	=>	'还款来源情况说明',
					'type'	=>	'textarea',
					'default'	=>	'',
					'inputOptions'	=>	[
						'class'	=>	'col-lg-7'
					],
					'validator'	=>	[
						'required'	=>	true,
					]
				],
			],
			'reface'	=>	[
				'uid'	=>	null,
				'amount'	=>	null,
				'deadline'	=>	null,
				'apr'	=>	null,
				'repay_method'	=>	null,
				'reason'	=>	null,
				'risk'	=>	null,
				'notice'	=>	null,
				'remark'	=>	null,
				'guarantee'	=>	null,
				'uptime'	=>	null
			]
		];
	}

	public function face($uid)
	{
		return (new Face())->_face($uid, $this->data);
	}

	public function reface()
	{
		$uid = $this->data['uid'];
		unset($this->data['uid']);
		return (new Face())->reface($uid, $this->data);
	}
}
