<?php

namespace app\controllers;

class SiteController extends Controller
{
	public function actionIndex()
	{
		print_r($this->session->get('admini'));
	}
}
