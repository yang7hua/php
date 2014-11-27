<?php

class Controller extends \Base\Controller
{

	public function initialize()
	{
		parent::initialize();
		if ($this->isLogin()) {
			$this->view->setVars([
					'_operator'	=>	self::operator()
				]);
		}
	}

	public function isLogin()
	{
		return $this->session->has('operator');
	}

	/**
	 * 获取当前操作者相关session信息
	 */
	public static function operator($key = '')
	{
		$session = $_SESSION['operator'];
		if (!is_array($session))
			return [];
		if ($key and array_key_exists($key, $session))
			return $session[$key];
		return $session;
	}

	/**
	 * 检查操作权限
	 * sysadm: adm_auth
	 * loansys: o_auth
	 */
	public function checkAuth()
	{
		if (!$this->allowedAction())
			$this->pageError('permission');
	}

	/**
	 * 检查登录
	 */
	public function allowedAction($actionName = '')
	{
		$appname = APP_NAME;
		$controllerName = $this->getControllerName();
		$auth = self::operator('auth');

		if (empty($actionName))
			$actionName = $this->getActionName();

		if (in_array($controllerName, ['public']))
			return true;

		$allowed = true;

		if (empty($auth) || !isset($auth[$appname]) || !array_key_exists($controllerName, $auth[$appname]))
			$allowed = false;	
		else {
			$authActions = $auth[$appname][$controllerName];
			$allowedActions = [];
			$actions = $this->actions();
			foreach ($authActions as $action) {
				if (array_key_exists($action, $actions))	
					$allowedActions = array_merge($allowedActions, $actions[$action]);
			}	
			if (!array_key_exists($actionName, $allowedActions))
				$allowed = false;
		}

		return $allowed;
	}

	/**
	 * 获取当前操作者对当前控制器的权限
	 */
	public function getAuthByController()
	{
		$auth = $this->operator('auth');

		if ($auth[APP_NAME] and is_array($auth[APP_NAME]))
			$auth = $auth[APP_NAME];
		else
			return [];

		$controllerName = $this->getControllerName(); 
		if (isset($auth[$controllerName]))
			$auth = $auth[$controllerName];
		else
			return [];

		return $auth;
	}

	/**
	 * 获取当前操作者id
	 */
	public function getOperatorId()
	{
		return $this->operator('oid');
	}

	/**
	 * 获取当前操作者门店id
	 */
	public function getOperatorBid()
	{
		return $this->operator('bid');
	}

	/**
	 * 通过制定权限值获取对应操作
	 */
	public function getActionsByAuth($auth)
	{
		$_actions = [];
		$actions = $this->actions();
		if (is_string($auth))
			$_actions = array_key_exists($auth, $actions) ? $actions[$auth] : [];
		if (is_array($auth))
		{
			foreach ($auth as $row)
			{
				if (array_key_exists($row, $actions))
					$_actions = array_merge($_actions, $actions[$row]);
			}
		}
		return $_actions;
	}

	/**
	 * 判断是否具有当前控制器某操作的权限
	 */
	public function	authHasAction($actionName, $controllerName = '')
	{
		if (!$controllerName)
			$controllerName = strtolower(str_replace('Controller', '', get_class()));
		$auth = $this->getAuthByController($controllerName);
		
		$actions = $this->getActionsByAuth($auth);

		return array_key_exists($actionName, $actions);
	}

	/**
	 * 获取url参数
	 */
	public function urlParam($index = 0)
	{
		return $this->dispatcher->getParams()[$index];
	}
}
