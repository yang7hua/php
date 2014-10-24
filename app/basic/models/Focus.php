<?php

namespace app\models;

use yii\db\ActiveRecord;

class Focus extends ActiveRecord
{
	const TYPE_INDEX = 1;

	private static $size = [
		'index'	=>	[680, 280]
	];

	public static function tableName()
	{
		return 'focus';
	}

	public static function getSize($type = 'index')
	{
		return self::$size[$type];
	}

	public static function getFocus($type = self::TYPE_INDEX)
	{
		$where['type'] = 1;
		$data = Focus::find()
					->where($where)
					->asArray()
					->orderBy(['sortno'=>SORT_ASC, 'id'=>SORT_DESC])
					->all();
		return $data;
	}

	public static function types()
	{
		return [
			self::TYPE_INDEX => '首页'
		];
	}
}
