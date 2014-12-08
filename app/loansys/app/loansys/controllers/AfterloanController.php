<?php

/**
 * 贷后管理
 */
class AfterloanController extends Controller
{
	public static function authorities()
	{
		return [
			'afterloan'	=>	[
				'name'	=>	'贷后管理',
				'authorities'	=>	[
					'operate'	=>	'管理'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'operate'	=>	[
				'list'	=>	['text'	=>	'贷后列表', 'link'	=>	true],
				'detail'	=>	['text'	=>	'详情']
			]
		];
	}
}
