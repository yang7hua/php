<?php

class CheckForm extends ModelForm
{
	public static function fields()
	{
		return [
			'visit'	=>	[
				'oid'	=>	null,
				'addtime'	=>	null,
				'uid'	=>	null,
				'visit_company_address'	=>	[
					'validator'	=>	[
						'required'	=>	true
					]
				],
				'license_compay_address'	=>	[
					'validator'	=>	[
						'required'	=>	true,
					]
				],
				'license_company_address'	=>	[
					'default'	=>	0
				],
				'income_company_address'	=>	[
					'default'	=>	0
				],
				'company_status'	=>	[],
				'company_area'	=>	[],
				'company_decorate'	=>	[],
				'company_industry'	=>	[],
				'company_people_number'	=>	[],
				'company_info'	=>	[],
				'job_year'	=>	[],
				'job_duty'	=>	[],
				'job_income'	=>	[],
				'invest_amount'	=>	[],
				'invest_rate'	=>	[],
				'job_company'	=>	[],
				'visit_address'	=>	[],
				'house_live_address'	=>	[],
				'house_live_ofter'	=>	[],
				'job_company'	=>	[],
			]
		];
	}

	/**
	 * 上门审核
	 */
	public function visit()
	{
		return (new Check())->add($this->data);
	}
}
