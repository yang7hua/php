<?php

class VisitForm extends ModelForm
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
				'house_live_address'	=>	[
					'default'	=>	0
				],
				'house_live_address_info'	=>	[],
				'house_live_often'	=>	[
					'default'	=>	0
				],
				'job_company'	=>	[],
			],
			'car'	=>	[
				'uid'	=>	null,
				'car_loan'	=>	[], 
				'car_otherhand'	=>	[], 
				'car_secondhand_info'	=>	[], 
				'car_brand'	=>	[], 
				'car_type'	=>	[],
				'car_price'	=>	[], 
				'car_buytime'	=>	[], 
				'car_appearance'	=>	[], 
				'car_inappearance'	=>	[], 
				'car_accident_info'	=>	[],
				'car_fall_price'	=>	[], 
				'car_assess_price'	=>	[], 
				'car_sys_assess_price'	=>	[]		 
			]
		];
	}

	/**
	 * 上门审核
	 */
	public function visit()
	{
		return (new Visit())->add($this->data);
	}
}
