<?php

class Branch extends Model
{
	public static function getNameById($id)
	{
		$info = self::findFirst(intval($id));
		if (!$info)
			return null;
		return $info->name;
	}
}
