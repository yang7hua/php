<?php

namespace app\models\user\site;

use app\models\Focus;

class FocusForm extends Focus
{
	public $title;
	public $image;
	public $type;

	public function attributeLabels()
	{
		return [
			'title'	=>	'标题',
			'image'	=>	'图片',
			'type'	=>	'位置'
		];
	}

	public function rules()
	{
		return [
			[['title', 'image', 'type'], 'required'],
			['image', 'validateImage']
		];
	}

	public function validateImage($attribute, $params)
	{
		if (!file_exists($this->image)) {
			$this->addError($attribute, '该图片地址已不存在');
		}
	}
}
