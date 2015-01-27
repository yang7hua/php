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
			20	=>	'严重碰撞'
		];
	}

	public static function inappearance()
	{
		return [
			0	=>	'无',
			3	=>	'轻微刮蹭',
			10	=>	'多次刮蹭',
			15	=>	'轻微碰撞',
			20	=>	'严重碰撞'
		];
	}

	//性质
	public static function carNature()
	{
		return [
			1	=>	'私有',
			0	=>	'公有'
		];
	}
	//技术状况
	public static function statusTech()
	{
		return [
			1	=>	'好 1.2',
			10	=>	'一般 1',
			20	=>	'差 0.8'
		];
	}

	//维修保养
	public static function statusMaintain()
	{
		return [
			1	=>	'好 1.1',
			10	=>	'一般 1',
			20	=>	'差 0.9'
		];
	}

	//制造质量
	public static function makeQuality()
	{
		return [
			1	=>	'进口 1.1',
			10	=>	'国产品牌 1',
			20	=>	'国产非品牌 0.9'
		];
	}

	//工作性质
	public static function workNature()
	{
		return [
			1	=>	'私用 1.2',
			10	=>	'公务用车 1',
			20	=>	'营运 0.7'
		];
	}

	//工作条件
	public static function workStatus()
	{
		return [
			1	=>	'较好 1',
			10	=>	'一般 0.9',
			20	=>	'较差 0.8'
		];
	}
}
