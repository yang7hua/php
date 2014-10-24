<?php

namespace app\models\user\site;

use app\models\Info;

class InfoForm extends Info 
{
	public $title;
	public $keywords;
	public $description;

	public function attributeLabels()
	{
		return [
			'title'	=>	'网站标题',
			'keywords'	=>	'关键词',
			'description'	=>	'网站描述',
		];
	}

	public function rules()
	{
		return [
			[['title','keywords','description'], 'required']
		];
	}

	//修改配置信息
	public function edit()
	{
		if ($this->validate()) {
			return parent::updateSiteinfo(['title', 'keywords', 'description'], $this);
		}
		return false;
	}
}
