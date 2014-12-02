<?php

class Authority extends Model
{

	public static function all($appname = '')
	{
		static $authorities = null;

		if (!$authorities)
			$authorities = \App\Authority::authorities();

		if (empty($appname) and array_key_exists($appname, $authorities))
			return $authorities[$appname];

		return $authorities;
	}

	public static function getAuthByRid($rid)
	{
		$role =  Role::findById($rid);
		if (!$role || empty($role['auth']))
			return [];
		$auth = unserialize($role['auth']);
		return $auth;
	}

}
