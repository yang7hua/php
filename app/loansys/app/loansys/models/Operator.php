<?php

class Operator extends Model
{

	const STATUS_FREEZE = 10;

	public static function findById($id)
	{
		$info = self::findFirst($id)->toArray();
		return $info;
	}

	public static function getAuthByRid($rid)
	{
		$role = Role::findById($rid);
		return unserialize($role['auth']);
	}

	public static function login($data)
	{
		$info = self::findFirst("username='{$data['username']}'");
		if (!$info || $info->password != $data['password'])
			return false;
		return $info;
	}
}
