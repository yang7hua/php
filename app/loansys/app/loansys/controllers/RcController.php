<?php
//全国风控中心

class RcController extends Controller
{
	public static function authorities()
	{
		return [
			'rc'	=>	[
				'name'	=>	'风控中心',
				'nationwide'	=>	true,//全国
				'authorities'	=>	[
					'operate'	=>	'审批'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'operate'	=>	[
			]
		];
	}
}
