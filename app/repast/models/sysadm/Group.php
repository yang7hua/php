<?php

namespace app\models\sysadm;

class Group extends \app\models\Model
{

	public static function format($list)
	{
		foreach ($list as &$row)
		{

		}
		return $list;
	}

	public static function all($where= '', $offset = 0, $limit = 1)
	{
		$list = Group::find()
				->where($where)
				->asArray()
				->offset($offset)
				->limit($limit)
				->all();
		return self::format($list);
	}

}
