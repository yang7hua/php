<?php

class CarForm extends ModelForm
{
	public static function fields()
	{
		return [
			'assess'	=>	[
				'uid'	=>	null,
				'oid'	=>	null,
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
				'car_sys_assess_price'	=>	[],
				'car_remark'	=>	[]
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
