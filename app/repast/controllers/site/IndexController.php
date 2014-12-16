<?php

namespace app\controllers\site;

class IndexController extends Controller
{
	public function actionIndex($id = 1)
	{
		return $this->render('index');
	}
}
