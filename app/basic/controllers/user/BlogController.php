<?php

namespace app\controllers\user;

use app\models\user\BlogForm;
use app\models\Category;
use app\models\user\CategoryForm;
use app\models\Tags;
use app\models\user\Blog;

class BlogController extends UserController
{
	public function actionPublish()
	{
		$model = new BlogForm();

		$post = \Yii::$app->request->post();
		if ($post['blogform-content'])
			$post['BlogForm']['content'] = $post['blogform-content'];
		if ($model->load($post) && $model->add()) {
			return $this->redirect('/user');
		}

		$render = [
			'model'	=>	$model,
			'category'	=> self::category()	
		];
		
		$this->noSidebar();
		return $this->render('/user/blog/publish', $render);
	}

	public static function category()
	{
		$return = null;
		$category = Category::all();
		if (count($category)) {
			foreach ($category as $val) {
				$return[$val['cid']] = $val['name'];
			}
		} 
		return $return;
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
		$data = Blog::all();
		return $this->render('/user/blog/list', ['data'=>$data]);
	}

	public function actionEdit()
	{
		$model = new BlogForm();

		if (\Yii::$app->request->post('do') == 'edit') {
			$post = \Yii::$app->request->post();
			if (!$post['id'])
				return false;
			$id = intval($post['id']);
			$form_data = $post['BlogForm'];
			if ($post['blogform-content'])
				$form_data['content'] = $post['blogform-content'];
			$form_data['id'] = $id;
			$form_data['allow_review'] = intval($form_data['allow_review']);
			$form_data['is_private'] = intval($form_data['is_private']);

			$post['BlogForm'] = $form_data;
			if ($model->load($post) && $model->save($post['id'])) {
				return $this->redirect('/user');
			}
		} else {
			$id = intval(\Yii::$app->request->get('id'));
			if (!$id)
				return;
			$info = Blog::detail($id);
		}

		$this->noSidebar();
		return $this->render('/user/blog/publish', ['info'=>$info, 'do'=>'edit', 'model'=>$model, 'category'=>self::category()]);
	}

}
