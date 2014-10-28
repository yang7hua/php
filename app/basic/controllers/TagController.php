<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Tags;
use app\models\Blog;

class TagController extends BaseController
{
	public function actionTag($tag)
	{
		$ids = Tags::getBlogsByTag($tag);
		$list = Blog::getByIds($ids);
		return $this->render('/site/list', ['data'=>$list]);
	}
}
