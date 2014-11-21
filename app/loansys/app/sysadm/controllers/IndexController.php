<?php

class IndexController extends Controller
{
	public static function actions()
	{
		return [
				'index'	=>	['index']
			];
	}

	public static function authorities()
	{
		return [
			'index'	=>	[
				'name'	=>	'控制台',
				'authorities'	=>	[
					'index'	=>	'主页'
				]
			]
		];
	}

	public function indexAction()
	{
		echo 'adm/index';
	}
}
