<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Blog;
use app\models\Category;

class BlogController extends BaseController
{
	public function actionDetail()
	{
		$id = intval(\Yii::$app->request->get('id'));
		$detail = Blog::detail($id);
		$detail['content'] = htmlspecialchars_decode($detail['content']);
		Blog::readInc($id);
		return $this->render('/site/detail', $detail);
	}

	public function actionTopic()
	{
		static $topics = ['today', 'hot'];
		$topic = \Yii::$app->request->get('topic');
		if (in_array($topic, $topics)) {
			switch ($topic) {
				case 'hot':
					$title = '热门推荐';
					$list = Blog::hotList();
					break;
				default:
					break;
			}
		} else if (is_numeric($topic)) {
			$cid = intval($topic);
			$list = Blog::getListByCid($cid);
			$title = Category::getName($cid);
		}

		$this->getView()->params['title'] = $title;
		$this->getView()->params['description'] = $title;
		return $this->render('/site/list', ['data'=>$list]);
	}
}
