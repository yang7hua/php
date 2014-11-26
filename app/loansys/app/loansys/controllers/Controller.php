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
}
