<?php
/**
 * 核查信息
 */
class Check extends Model
{
	public static function baseinfo($uid)
	{
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return [];
		return $info->toArray();
	}
}
