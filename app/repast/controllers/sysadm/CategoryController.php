<?php

namespace app\controllers\sysadm;

use app\models\sysadm\Category;
use app\models\sysadm\CategoryForm;

class CategoryController extends Controller
{
	public function actionList()
	{
		$list = Category::all();
		return $this->render('list', ['list'	=>  $list]);
	}

	public function actionAdd()
	{
		$model = new CategoryForm(['scenario'	=>	'add']);

		if ($model->load(\Yii::$app->request->post()) and $model->add())
		{
			$this->redirect('/category/list');
		}
		return $this->render('add', ['model'	=>	$model]);
	}

	public function actionEdit($id)
	{
		$model = new CategoryForm(['scenario'	=>	'add']);

		if ($model->load(\Yii::$app->request->post()) and $model->edit($id))
		{
			$this->success();
			$this->redirect('/category/list');
		}

		$category = Category::findOne($id);
		!$category and $this->error('param error');

		$model->name	= $category->name;
		$model->status	= $category->status;

		return $this->render('add', [
			'model'	=>	$model
		]);
	}
}
