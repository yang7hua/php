<?php

namespace app\controllers;

class SiteController extends Controller
{
	public function actionIndex()
	{
		return $this->render('/index');
	}
}
