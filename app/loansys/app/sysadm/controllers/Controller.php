<?php

class Controller extends \Phf\Mvc\Controller
{
	protected $view = null;

	protected $router = null;

	//无需登录的板块
	private static $allowed_controllers = [
		//controllerName =>	[actionName]
		'public'	=>	'*'
	];

	public function initialize()
	{
		global $view;
		$this->view = $view;

		global $router;
		$this->router = $router;

		$this->checkAllowed();
	}

	/**
	 * 检查需要登陆的板块 
	 * 如果需要登陆但是又没登录则跳转到登录界面
	 */
	private function checkAllowed()
	{
		$needLogin = false;
		$controllerName = $this->getControllerName();
		$actionName = $this->getActionName();

		if (!array_key_exists($controllerName, self::$allowed_controllers)) {
			$needLogin = true;
		} else if ( self::$allowed_controllers[$controllerName] != '*' 
					and !in_array($actionName, self::$allowed_controllers[$controllerName]) ) {
			$needLogin = true;
		}
		
		if ($needLogin and !$this->isLogin())
			$this->redirect(\Func\url('/public/login', true));

		return;
	}

	/**
	 * 但页面
	 */
	public function single($pagename)
	{
		$this->noMainLayout();
		$this->view->render('single', $pagename);
		exit();
	}

	/**
	 * 重定向
	 */
	public function redirect($url)
	{
		$this->response->redirect($url)->sendHeaders();
	}

	public function getControllerName()
	{
		return $this->router->getControllerName();
	}

	public function getActionName()
	{
		return $this->router->getActionName();
	}

	/**
	 * 检测是否登录
	 */
	public function isLogin()
	{
		return $this->session->get('oid') != null;
	}

	public function emptyAction()
	{
		echo 'base Controller .';
	}

	public function isAjax()
	{
		if ($this->request->isAjax() || $this->request->get('format') === 'json')
			return true;
		return false;
	}

	public function ajaxReturn($data, $success = true)
	{
		$return = array();
		$return['ret'] = $success ? 1 : 0;
		if($success){
			if(is_string($data))
				$return['msg'] = $data;
			else if(is_array($data))
				$return['data'] = $data;
		}else{
			$return['msg'] = $data;
		}
		exit(json_encode($return));
	}

	/**
	 * ajax返回错误数据
	 */
	public function error($output)
	{
		$this->ajaxReturn($output, false);
	}

	/**
	 * ajax返回成功数据
	 */
	public function success($output)
	{
		$this->ajaxReturn($output);
	}

	/**
	 * 失败单页面
	 */
	public function _404($err)
	{
		$this->view->setLayout('single');
		$this->view->setVars($err);
		return $this->view->pick('/single/404');
	}

	/**
	 * 禁用layout
	 * @param $main: true则同时禁用main layout
	 */
	public function noLayout($main = false)
	{
		$opts = [
			\Phf\Mvc\View::LEVEL_LAYOUT	=>	true
		];
		if ($main)
			$opts[\Phf\Mvc\View::LEVEL_MAIN_LAYOUT] = true;

		$this->view->disableLevel($opts);
	}

	/**
	 * 禁用main layout
	 */
	public function noMainLayout()
	{
		$this->view->disableLevel([
			\Phf\Mvc\View::LEVEL_MAIN_LAYOUT => true
		]);
	}

	/**
	 * 错误单页面
	 */
	public function pageError($type = '')
	{
		$params = [];
		switch ($type) {
			case 'param':
				$params['msg'] = '参数错误';
				break;
			default:
				$params['msg'] = '页面不存在';
				break;
		}
		$this->_404($params);
	}

	/**
	 * 成功单页面
	 */
	public function pageSuccess($msg, $url, $seconds = 3)
	{
		$this->view->setLayout('single');
		$this->view->setVars([
			'msg'	=>	$msg,
			'seconds'	=>	$seconds,
			'url'	=>	$url	
		]);
		$this->view->pick('single/success');
	}
}
