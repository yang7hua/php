<?php

namespace app\models;

use yii\base\Model;
use app\models\Category;

class CategoryForm extends Model
{
	public $name;

	public function rules()
	{
		return [
			['name', 'required'],
			['name', 'string', 'max'=>10],
			['name', 'uniquedName']
		];
	}

	public function attributeLabels()
	{
		return [
				'name'	=>	'分类名称'
			];
	}

	public function uniquedName($attribute, $params)
	{
		if (Category::findByName($this->name))
			$this->addError($attribute, '该分类已存在');
	}

	public function add()
	{
		if ($this->validate()) {
			return Category::add([
					'name'	=>	$this->name,
					'pid'	=>	0
				]);
		}
		return false;
	}
}
