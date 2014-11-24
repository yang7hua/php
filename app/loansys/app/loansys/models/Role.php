<?php

class Role extends Model
{
	public static function findById($id)
	{
		$info = self::findFirst($id);
		if (!$info)
			return null;
		return $info->toArray();
	}
}
