<?php

namespace app\controllers\user;

class IndexController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}
