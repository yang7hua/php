<?php

namespace app\models\sysadm;

use app\models\sysadm\Admini;

class CategoryForm extends \app\models\ModelForm
{
	public $name;
	public $status;

	public function rules()
	{
		return [
			[['name', 'status'], 'required'],
		];
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['add'] = ['name', 'status'];
		return $scenarios;
	}

	public function attributeLabels()
	{
		return [
			'name'	=>	'分类名称',
			'status'	=>	'是否显示'
		];
	}

	public function add()
	{
		if ($this->validate())
		{
			return Category::add($this);
		}
	}

	public function edit($id)
	{
		if ($this->validate())
		{
			return Category::edit($id, $this);
		}
	}
}
