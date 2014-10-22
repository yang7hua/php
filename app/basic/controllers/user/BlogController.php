<?php

namespace app\controllers\user;

use app\models\BlogForm;
use app\models\Category;
use app\models\CategoryForm;
use app\models\Tags;
use app\models\Blog;

class BlogController extends UserController
{
	public function actionPublish()
	{
		$model = new BlogForm();

		$post = \Yii::$app->request->post();
		if ($post['blogform-content'])
			$post['BlogForm']['content'] = $post['blogform-content'];
		if ($model->load($post) && $model->add()) {
			return $this->redirect('/user/blog/list');
		}

		$render = [
			'model'	=>	$model,
			'category'	=>	[]
		];
		
		$category = Category::all();
		if (count($category)) {
			foreach ($category as $val) {
				$render['category'][$val['cid']] = $val['name'];
			}
		} else {
			$render['category'] = null;
		}

		return $this->render('/user/blog/publish', $render);
	}

	public function actionAddcategory()
	{
		$model = new CategoryForm();
		if ($model->load(\Yii::$app->request->post()) && $model->add()) {
			return $this->redirect('/user/blog/publish');
		}
	}

	public function actionList()
	{
		if ($this->isAjax()) {
			$data = Blog::_list();
			return $this->ajaxReturn(['data'=>$data]);
		}
	}

}
