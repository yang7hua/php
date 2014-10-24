<?php

namespace app\controllers\user;

use app\models\user\BlogForm;
use app\models\Category;
use app\models\user\CategoryForm;
use app\models\Tags;
use app\models\user\Blog;
use app\models\user\site\Focus;
use app\models\user\site\FocusForm;

class BlogController extends UserController
{
	//发布博客
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

	//博客分类
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

	//添加博客分类
	public function actionAddcategory()
	{
		$model = new CategoryForm();
		if ($model->load(\Yii::$app->request->post()) && $model->add()) {
			return $this->redirect('/user/blog/publish');
		}
	}

	//博客列表
	public function actionList()
	{
		if ($this->isAjax()) {
			$data = Blog::_list();
			return $this->ajaxReturn(['data'=>$data]);
		}
		$data = Blog::all();
		return $this->render('/user/blog/list', ['data'=>$data]);
	}

	//编辑博客
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

	//获取博客基本信息
	public function actionBaseinfo()	
	{
		$id = \Yii::$app->request->post('id');
		$info = Blog::baseinfo($id);
		return $this->ajaxReturn(['data'=>$info]);
	}

	//添加到焦点图片
	public function actionTofocus()
	{
		$post = \Yii::$app->request->post();
		if (empty($post['blog_id']) || empty($post['title']) || empty($post['image']))
			return $this->ajaxReturn('参数错误', false);
			
		$blog = Blog::findOne(intval($post['blog_id']));

		if (!$blog)
			return $this->ajaxReturn('此博客不存在', false);
		if (!file_exists($post['image']))
			return $this->ajaxReturn('图片不存在', false);
		if ($blog->is_private == 1 || $blog->status != Blog::STATUS_PUBLISH)
			return $this->ajaxReturn('此博客不能添加到焦点图', false);
		if (Focus::exist($post['blog_id'], $post['type']))
			return $this->ajaxReturn('此焦点图已存在', false);
		
		//先裁剪
		$size = Focus::getSize();
		$post['image'] = $this->thumb($post['image'], $size[0], $size[1]);

		if (Focus::add($post)) {
			$blog->is_focus = 1;
			if ($blog->save())
				return $this->ajaxReturn('操作成功');
			else
				return $this->ajaxReturn('操作失败', false);
		}
		return $this->ajaxReturn('操作失败', false);
	}

}
