<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Blog;

class SearchController extends BaseController
{
	public function actionSearch($keyword)
	{
		$data = Blog::search($keyword);
		$data['list'] = self::highlight($data['list'], $keyword);

		return $this->render('/site/list', ['data'=>$data, 'keyword'=>$keyword]);
	}

	public static function highlight($data, $keyword)
	{
		if (!is_array($data))
			return $data;
		foreach ($data as &$row) {
			$row['title'] = str_replace($keyword, "<span class='highlight'>$keyword</span>", $row['title']);
		}
		return $data;
	}
}
