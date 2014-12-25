<?php

namespace app\models\sysadm;

use app\models\sysadm\Menu;

class MenuForm extends \app\models\ModelForm
{
	public $cid;
	public $aid;
	public $title;
	public $price;
	public $favorable_price;
	public $img;
	public $new;
	public $provide_time;
	public $peppery;
	public $description;
	public $status;

	public function rules()
	{
		return [
			[['cid', 'title', 'price', 'peppery', 'status', 'new', 'provide_time'], 'required'],
			['price', 'validatePrice'],
			['favorable_price', 'validatePrice']
		];
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['add'] = ['cid', 'aid', 'title', 'price', 'favorable_price',
			'img', 'provide_time', 'new', 'peppery', 'description', 'status'];
		return $scenarios;
	}

	public function attributeLabels()
	{
		return [
			'cid'	=>	'分类名称',
			'aid'	=>	'活动',
			'title'	=>	'菜单名称',
			'price'	=>	'价格',
			'favorable_price'	=>	'优惠价格',
			'img'	=>	'图片',
			'new'	=>	'新品',
			'provide_time'	=>	'供应时间',
			'peppery'	=>	'辣度',
			'description'	=>	'描述',
			'status'	=>	'状态'
		];
	}

	public function validatePrice($attribute, $params)
	{
		if (!$this->hasErrors())
		{
			if (!preg_match('/^\d+(\.\d{1,2})?$/', $this->price))
				$this->addError($attribute, '价格格式不正确');
		}
	}

	public function add()
	{
		if ($this->validate())
		{
			return Menu::add($this);
		}
		return false;
	}

	public function edit($id)
	{
		if ($this->validate())
		{
			return Menu::edit($id, $this);
		}
	}
}
