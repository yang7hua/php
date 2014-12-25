<?php

namespace app\models\sysadm;

class GroupForm extends \app\models\ModelForm
{
	public $price;
	public $favorable_price;
	public $mids;
	public $description;
	public $status;

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['add'] = [];
		return $scenarios;
	}

	public function attributeLabels()
	{
		return [
			'price'	=>	'套餐价格',
			'favorable_price'	=>	'优惠价格',
			'description'	=>	'描述',
			'status'	=>	'状态'
		];
	}

	public function rules()
	{
		return [
			[['price', 'favorable_price', 'status', 'mids'], 'require']
		];
	}
}
