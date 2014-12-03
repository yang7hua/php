<?php

namespace Apps;

/**
 * 权限
 */
class Authority
{

	static $apps = [FRONT_NAME, ADM_NAME];

	/**
	 * 获取所有控制器的权限配置
	 */
	public static function authorities()
	{
		static $authorities = [];

		if (!empty($authorities))
			return $authorities;

		$paths = [
			FRONT_NAME	=>	\App::getPathByApp(FRONT_NAME) . '/controllers'	
		];

		foreach ($paths as $app=>$path) {
			$files[$app] = glob($path . '/*Controller.php');
		}

		if (!is_array($files) and empty($files))
			return $authorities;

		foreach ($files as $app=>$appfiles) {
			$app_authorities = [];
			foreach ($appfiles as $file) {
				$classname = pathinfo($file)['filename'];
				$newAuthorities = $classname::authorities();
				$basecname = strtolower(str_replace('Controller', '', $classname));
				if (!empty($newAuthorities))
					$app_authorities = array_merge($app_authorities, $newAuthorities);
			}
			$authorities[$app] = $app_authorities;
		}
		return $authorities;
	}

	/**
	 * 按项目名称获取权限
	 */
	public static function getAuthoriesByAppname($authories, $appname)
	{
		return array_key_exists($appname, $authories) ? $authories[$appname] : [];
	}

	/**
	 * 如果不是全国中心操作人员，则过滤掉只有全国操作人员才有的配置
	 */
	public static function getAuthoriesByBid($authories, $nationWideBid = false)
	{
		foreach ($authories as $appname=>$app_authories)
		{
			foreach ($app_authories as $controllerName=>$_authories)
			{
				if (isset($_authories['nationwide']))
				{
					if (!$nationWideBid)
						unset($authories[$appname][$controllerName]);
				}
			}
		}
		//print_r($authories);
		return $authories;
	}

	/**
	 * 该操作器是否存在
	 */
	public static function controllerExist($auth, $controller, $appname = '')
	{
		if (empty($auth))
			return false;
		if (empty($appname))
			$appname = APP_NAME;
		if (!isset($auth[$appname]))
			return false;
		return array_key_exists($controller, $auth[$appname]);
	}

	/**
	 * 操作器下的某操作方法是否存在
	 */
	public static function actionExist($auth, $controller, $action, $appname = '')
	{
		if (empty($appname))
			$appname = APP_NAME;
		if (!self::controllerExist($auth, $controller, $appname))
			return false;
		return in_array($action, $auth[$appname][$controller]);
	}

	/**
	 * 根据角色获取能操作的actions
	 * 用于放在页面顶部作为快捷链接
	 */
	public static function getQuickLinks()
	{
		static $links = null;

		if (!is_null($links))
			return $links;

		//操作者权限
		$_authes = \App::session('auth', 'operator');
		if (!is_array($_authes))
			return $links;

		//当前操作者在当前app下的权限
		$_authes = self::getAuthoriesByAppname($_authes, APP_NAME);

		$links = [];
		//将允许的控制器和方法放入数组
		$allowed_actions = [];
		foreach ($_authes as $controller=>$actions) {
			$_controller = ucfirst($controller) . 'Controller';	
			//控制器的actions
			$_actions = $_controller::actions();
			if (!$_actions)
				continue;
			$allowed_controller_actions = [];
			foreach ($actions as $action) {
				$allowed_controller_actions = array_merge($allowed_controller_actions, $_actions[$action]);
			}
			$allowed_actions[$controller] = $allowed_controller_actions;
		}
		if (!empty($allowed_actions))
		{
			foreach ($allowed_actions as $controller=>$actions)
			{
				foreach ($actions as $action=>$text)
				{
					if (is_null($text))
						continue;
					if (is_array($text) and $text['link']) {
						$action == 'index' and $action = '';
						$links[] = [
							'url'	=>	\Func\url("$controller/$action"), 
							'text'	=>	$text['text']
							];
					}
				}
			}
		}
		return $links;	
	}

}
