<?php

namespace app\controllers\user;

use app\controllers\user\UserController;

class SiteController extends UserController
{
	private $menus;
	
	public function init()
	{
		if (!$this->isSuper())
			exit();
		$this->noSidebar();
		$this->menus = $this->siteMenus();
	}

	public function getInfoByCode($code = 'info')
	{
		foreach ($this->menus as $menu) {
			if ($menu['code'] == $code)
				return $menu;
		}
		return null;
	}

	public function actionIndex()
	{
		$code = \Yii::$app->request->get('code');
		$info = $this->getInfoByCode($code ? $code : 'info');

		return $this->render('/user/site', ['info'=>$info]);
	}

}
