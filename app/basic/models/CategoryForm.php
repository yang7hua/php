<?php

namespace app\models;

use yii\base\Model;

class CategoryForm extends Model
{
	public $name;

	public function attributeLabels()
	{
		return [
				'name'	=>	'分类名称'
			];
	}
}
