<?php

namespace app\controllers\user;

use app\controllers\user\UserController;
use app\models\Info;
use app\models\user\site\InfoForm;

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

	public function getMenuByCode($code = 'info')
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
		$menu = $this->getMenuByCode($code ? $code : 'info');

		$info = Info::siteInfo();

		$model = new InfoForm();
		if ($model->load(\Yii::$app->request->post()) && $model->edit()) {
			return $this->redirect('/user/site');
		}
		return $this->render('/user/site', ['menu'=>$menu, 'info'=>$info]);
	}

}
