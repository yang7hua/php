<?php

namespace app\models\sysadm;

class Menu extends \app\models\Model
{
	public static function status()
	{
		return [
			1	=>	'上架',
			10	=>	'下架'
		];
	}

	public static function peppery()
	{
		return [
			0	=>	'不辣',
			1	=>	'1',
			2	=>	'2',
			3	=>	'3',
			4	=>	'4',
			5	=>	'5'
		];
	}

	public static function categories()
	{
		$categories = Category::find(['status'	=>	Category::STATUS_NORMAL])
			->asArray()
			->select('cid,name')
			->all();

		$options = [''	=>	'请选择'];
		if (!$categories)
			return $options;

		foreach ($categories as $row)
		{
			$options[$row['cid']] = $row['name'];
		}
		return $options;
	}

	public static function activities()
	{
		$options = [''	=>	'无'];
		return $options;
	}

}
