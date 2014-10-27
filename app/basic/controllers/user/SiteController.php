<?php

namespace app\controllers\user;

use app\controllers\user\UserController;
use app\models\Info;
use app\models\user\site\InfoForm;
use app\models\user\site\BannerForm;

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
		$do = \Yii::$app->request->get('do');

		if ($do && in_array($do, ['add']))
			return $this->{$code}($do);

		switch ($code) {
			case 'info' :
				$model = new InfoForm();
				if ($model->load(\Yii::$app->request->post()) && $model->edit()) {
					return $this->redirect('/user/site');
				}
				break;
			default:
				break;
		}

		$info = Info::siteInfo();
		$menu = $this->getMenuByCode($code ? $code : 'info');
		return $this->render('/user/site', ['menu'=>$menu, 'info'=>$info]);
	}

	public function banner($do)
	{
		$post['BannerForm'] = \Yii::$app->request->post();
		$model = new BannerForm();
		if ($model->load($post) && $model->validate()) {
			switch ($do) {
			case 'add':
				if ($model->add())
					return $this->redirect('/user/site/banner');
				break;
			default:
				break;
			}
		} else {
			return $this->ajaxReturn($model->getFirstErrors(), false);
		}
	}

}
