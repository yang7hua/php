<?php

namespace app\controllers\sysadm;

use app\models\sysadm\Menu;
use app\models\sysadm\MenuForm;

class MenuController extends Controller
{
	public function actionList()
	{
		$list = Menu::all();
		return $this->render('list', [
			'list'	=>	$list,
			'page'	=>	$page
		]);
	}

	public function _list()
	{
		return $this->redirect('menu/list');
	}

	public function actionAdd()
	{
		$model = new MenuForm(['scenario'	=>	'add']);

		if ($model->load(\Yii::$app->request->post()) and $model->add())
		{
			$this->success();
			return $this->_list();
		}

		return $this->render('add', [
			'model'	=>	$model
		]);
	}

	public function actionEdit($id)
	{
		$model = new MenuForm(['scenario'	=>	'add']);

		if ($model->load(\Yii::$app->request->post()) and $model->edit($id))
		{
			$this->success();
			return $this->_list();
		}

		$info = Menu::findOne($id);
		!$info and $this->error('参数错误');

		$model->title = $info->title;
		$model->cid = $info->cid;
		$model->aid = $info->aid;
		$model->price = $info->price;
		$model->favorable_price = $info->favorable_price;
		$model->new = $info->new;
		$model->provide_time = $info->provide_time;
		$model->peppery = $info->peppery;
		$model->status = $info->status;

		return $this->render('add', [
			'model'	=>	$model
		]);
	}

	/**
	 * 菜单图片管理
	 */
	public function actionImg($id)
	{
		$info = Menu::findOne($id);
		!$info and $this->error('参数错误');

		return $this->render('img', [
			'info'	=>	$info
		]);
	}
}
