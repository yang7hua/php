<?php
/**
 * 管理后台
 */
namespace app\controllers\sysadm;

class Controller extends \app\controllers\Controller
{

	public $layout = 'sysadm';

	protected $params = [
		'title'	=>	'管理后台'
	];

	public function init()
	{
		parent::init();
	}

	public function single($page, $params = [])
	{
		$this->layout = 'sysadm/single';
		return $this->render('/sysadm/single/' . $page, $params);
	}

}
