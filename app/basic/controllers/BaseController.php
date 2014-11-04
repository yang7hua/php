<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Info;

class BaseController extends Controller
{
	public function init()
	{
		$siteinfo = Info::siteInfo();
		$this->getView()->title = $siteinfo['title'];
		$this->getView()->params['keywords'] = explode(',', $siteinfo['keywords']);
		$this->getView()->params['description'] = $siteinfo['description'];
	}

	public function isAjax()
	{
		if (\Yii::$app->request->get('format') == 'json')
			return true;
		return \Yii::$app->request->isAjax;
	}

	public function ajaxReturn($data, $success=true)
	{
		$return = [];
		if (is_string($data))
			$return['msg'] = $data;
		else if (is_array($data))
			$return = array_merge($return, $data);
		$return['ret'] = $success ? 1 : 0;
		return json_encode($return);
	}

	public function isSuper()
	{
		return \Yii::$app->user->getId() == \Yii::$app->config->superId;
	}

	public function thumb($source, $width, $height, $unlink=false)
	{
		return \Yii::$app->util->thumb($source, $width, $height, $unlink);
	}

	public function thumbByWidth($source, $width)
	{
		return \Yii::$app->util->thumbByWidth($source, $width);
	}

	public function getPath($path)
	{
		return \Yii::$app->util->getPath($path);
	}

	public function crop($source, $width, $height, array $point)
	{
		return \Yii::$app->util->crop($source, $width, $height, $point);
	}
}
