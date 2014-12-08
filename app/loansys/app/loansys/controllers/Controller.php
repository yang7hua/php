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
	 * 检查权限
	 */
	public function allowedAction($actionName = '')
	{
		$actionName = $this->getActionName();
		$controllerName = $this->getControllerName();

		if (in_array($controllerName, ['public']))
			return true;

		if (in_array($controllerName, ['site']) and in_array($actionName, ['index']))
			return true;

		return $this->authHasAction($actionName, $controllerName);
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

	public function isNationWideBid()
	{
		return \App::isNationWideBid($this->getOperatorBid()); 
	}

	/**
	 * 获取当前操作者对某控制器的权限
	 */
	public function getAuthByController($controllerName = '')
	{
		static $auth = null;

		if (!$auth)
		{
			$auth = $this->operator('auth');
			if ($auth[APP_NAME] and is_array($auth[APP_NAME]))
				$auth = $auth[APP_NAME];
		}

		if (empty($controllerName))
			$controllerName = $this->getControllerName(); 
		if (isset($auth[$controllerName]))
			return $auth[$controllerName];
		else
			return [];
	}

	/**
	 * 获取控制器下的操作
	 */
	public function getActionsByControllerName($controllerName)
	{
		$controller = ucfirst($controllerName).'Controller';
		return $controller::actions();
	}


	/**
	 * 通过指定权限值获取对应操作
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
		if (empty($controllerName))
			$controllerName = strtolower(str_replace('Controller', '', get_class($this)));
		$auth = $this->getAuthByController($controllerName);
		
		$controllerActions = $this->getActionsByControllerName($controllerName);

		$actions = [];
		foreach ($auth as $val)
		{
			$actions = array_merge($actions, $controllerActions[$val]);
		}	

		return array_key_exists($actionName, $actions);
	}

}
