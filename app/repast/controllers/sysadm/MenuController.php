<?php

namespace app\controllers\sysadm;

use app\models\sysadm\Menu;
use app\models\sysadm\MenuForm;

class MenuController extends Controller
{
	public function actionList()
	{
		return $this->render('list', [
			'list'	=>	$list,
			'page'	=>	$page
		]);
	}

	public function actionAdd()
	{
		$model = new MenuForm(['scenario'	=>	'add']);

		if ($model->load(\Yii::$app->request->post()) and $model->add())
		{
			return $this->redirect('menu/list');
		}

		return $this->render('add', [
			'model'	=>	$model
		]);
	}
}
