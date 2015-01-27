<?php

class CarForm extends ModelForm
{
	public static function fields()
	{
		return [
			'assess'	=>	[
				'uid'	=>	null,
				'oid'	=>	null,
				'car_owner'	=>	[],
				'home_address'	=>	[],
				'mobile'	=>	[],
				'car_photos'	=>	[],
				'car_number'	=>	[],
				'car_nature'	=>	[],
				'car_brand'	=>	[], 
				'car_type'	=>	[],
				'car_color'	=>	[], 
				'car_vin'	=>	[], 
				'car_engine_number'	=>	[], 
				'car_seat_count'	=>	[], 
				'car_register_date'	=>	[], 
				'car_mileage'	=>	[], 
				'car_age'	=>	[], 
				'car_use'	=>	[], 
				'car_bill'	=>	[], 
				'car_register_license'	=>	[], 
				'car_legal_idcard'	=>	[], 
				'car_other_license'	=>	[], 
				'car_tax_addition'	=>	[], 
				'car_tax_use'	=>	[], 
				'car_insure'	=>	[], 
				'car_other_tax'	=>	[], 
				'car_status_tech'=>	[],
				'car_status_maintain'=>	[],
				'car_make_quality'=>	[],
				'car_work_nature'=>	[],
				'car_work_status'=>	[],
				'car_loan'	=>	[], 
				'car_loan_info'	=>	[], 
				'car_price'	=>	[], 
				'car_price_now'	=>	[], 
				'car_fall_price'	=>	[], 
				'car_new_rate'	=>	[], 
				'car_reset_capital'	=>	[], 
				'car_assess_price'	=>	[], 
				'car_sys_assess_price'	=>	[],
				'car_assess_remark'	=>	[]
			]
		];
	}

	/**
	 * 车评 
	 */
	public function assess()
	{
		return (new Car())->add($this->data);
	}
}
