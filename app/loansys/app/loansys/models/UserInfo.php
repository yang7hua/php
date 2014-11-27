<?php

/**
 * 面审相关信息
 */
class UserInfo extends Model
{
	public static function info($uid)
	{
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return [];
		return $info->toArray();
	}

	public function add($data)
	{
		$info = new UserInfo();
		foreach ($data as $field=>$value)
		{
			$info->$field = $value;
		}
		$result = $info->create();
		if (!$result)
			$this->outputErrors($info);
		return true;

	}
}
