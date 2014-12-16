<?php

namespace app\controllers\sysadm;

class IndexController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}
