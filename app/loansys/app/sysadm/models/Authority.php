<?php

class Authority extends Model
{

	public static function all($appname = '')
	{
		static $authorities = null;

		if (!$authorities)
			$authorities = App::authorities();

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

	public static function controllerExist($auth, $controller, $appname = '')
	{
		if (empty($auth))
			return false;
		if (empty($appname))
			$appname = APP_NAME;
		return array_key_exists($controller, $auth[$appname]);
	}

	public static function actionExist($auth, $controller, $action, $appname = '')
	{
		if (empty($appname))
			$appname = APP_NAME;
		if (!self::controllerExist($auth, $controller, $appname))
			return false;
		return in_array($action, $auth[$appname][$controller]);
	}

	public static function checkAction($controller, $action)
	{
	}

}
