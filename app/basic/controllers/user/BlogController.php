<?php

namespace app\controllers\user;

use app\web\controllers\user;
use app\models\BlogForm;
use app\models\Category;

class BlogController extends UserController
{
	public function actionPublish()
	{
		$model = new BlogForm();
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

	public function addcategory()
	{
		$js = '$("#addcategory").modal("show")';
		$this->getView()->registerJs($js);
	}
}
