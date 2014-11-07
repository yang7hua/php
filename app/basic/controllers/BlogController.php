<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Blog;
use app\models\Category;
use app\models\Review;

class BlogController extends BaseController
{
	//详情
	public function actionDetail()
	{
		$id = intval(\Yii::$app->request->get('id'));
		$detail = Blog::detail($id);
		$this->checkPermission($detail);
		$detail['content'] = htmlspecialchars_decode($detail['content']);
		Blog::readInc($id);
		return $this->render('/site/detail', $detail);
	}

	//检查是否有权限查看该文章
	public function checkPermission($detail)
	{
		if ($detail['is_private'] && $detail['uid'] != \Yii::$app->user->getId())
			return $this->goBack();
		if ($detail['status'] != Blog::STATUS_PUBLISH && $detail['uid'] != \Yii::$app->user->getId())
			return $this->goBack();
	}

	//分类阅读
	public function actionTopic()
	{
		static $topics = ['today', 'hot'];
		$topic = \Yii::$app->request->get('topic');
		$p = \Yii::$app->request->get('p', 1);
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

	//评论处理
	public function actionReview()
	{
		$id = \Yii::$app->request->post('id');

		$session_name = 'blog_review_'.$id;
		if (!$this->defend($session_name))
			return $this->ajaxReturn('评论过于频繁，稍后尝试', false);

		if (!Blog::allowReview($id))
			return $this->ajaxReturn('博客禁止评论', false);

		$nickname = \Yii::$app->request->post('nickname');
		$content = \Yii::$app->request->post('content');
		if ($info = Review::add(['pid'=>0, 'blog_id'=>$id, 'nickname'=>$nickname, 'content'=>$content], true)) {
			$review = [
				'nickname'	=>	$info->nickname,
				'content'	=>	htmlspecialchars_decode($info->content),
				'time'	=>	$info->time,
				'date'	=>	date('y/m/d', $info->time)
			];
			return $this->ajaxReturn(['info'=>$review]);
		} else
			return $this->ajaxReturn(Review::getError(), false);
	}
}
