<?php
/**
 * 网站前台
 */
namespace app\controllers\site;

class Controller extends \app\controllers\Controller
{

	protected $params = [
		'title' => '',
		'keywords'	=>	['订餐系统'],
		'description'	=>	'订餐系统'
	];

	public function init()
	{
		parent::init();
	}

}
