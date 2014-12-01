<?php

namespace App\Config;

class Car
{
	public static function loan()
	{
		return [
			1	=>	'全款车',
			10	=>	'贷款车'
		];
	}

	public static function otherhand()
	{
		return [
			1	=>	'一手车',
			2	=>	'二手车',
			3	=>	'三手车'
		];
	}

	public static function appearance()
	{
		return [
			0	=>	'无',
			3	=>	'轻微刮蹭',
			10	=>	'多次刮蹭',
			15	=>	'轻微碰撞',
			20	=>	'验证碰撞'
		];
	}

	public static function inappearance()
	{
		return [
			0	=>	'无',
			3	=>	'轻微刮蹭',
			10	=>	'多次刮蹭',
			15	=>	'轻微碰撞',
			20	=>	'验证碰撞'
		];
	}
}
