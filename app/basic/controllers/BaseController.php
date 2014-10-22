<?php
namespace app\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
	public function init()
	{
		$this->getView()->params['keywords'] = ['博客'];
		$this->getView()->title = '博客';
	}

	public function isAjax()
	{
		if (\Yii::$app->request->get('format') == 'json')
			return true;
		return \Yii::$app->request->isAjax;
	}

	public function ajaxReturn($data, $success=true)
	{
		$data['ret'] = $success ? 1 : 0;
		return json_encode($data);
	}

	public function thumb($source, $width, $height, $unlink=false)
	{
		$thumb = \yii\imagine\Image::thumbnail($this->getPath($source), $width, $height);

		$info = pathinfo($source);
		$filename = "{$info['dirname']}/{$info['filename']}_{$width}x{$height}.{$info['extension']}";
		$thumb->save($this->getPath($filename), ['quality' => 100]);

		if ($unlink)
			unlink($this->getPath($source));

		return $filename;
	}

	public function getPath($path)
	{
		return \Yii::$app->basePath . '/web/' . trim($path, '/');
	}

	public function crop($source, $width, $height, array $point)
	{
		$thumb = \yii\imagine\Image::crop($this->getPath($source), $width, $height, $point);

		$info = pathinfo($source);
		$filename = "{$info['dirname']}/crop_{$info['filename']}_{$width}x{$height}.{$info['extension']}";
		$thumb->save($this->getPath($filename), ['quality' => 100]);
		return $filename;
	}
}
