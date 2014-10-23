<?php

namespace app\models\user\site;

use app\models\user\site\Info;

class InfoForm extends Info 
{
	public $title;

	public function attributeLabels()
	{
		return [
			'title'	=>	'网站标题'
		];
	}
}
