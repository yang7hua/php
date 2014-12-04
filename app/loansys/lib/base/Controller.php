<?php

namespace Base;

class Controller extends \Phf\Mvc\Controller implements BaseInterface
{
	protected $view = null;

	protected $router = null;


	/*
	 * 返回权限配置
	 */
	static public function authorities()
	{
		return [];
	}

	public static function actions()
	{
		return [];
	}

	//无需登录的板块
	protected static $allowed_controllers = [
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
		$this->checkAuth();

		$this->view->setVar('_params', [
				'controller'	=>	$this->getControllerName(),
				'action'	=>	$this->getActionName()
			]);
	}

	/**
	 * 检查需要登陆的板块 
	 * 如果需要登陆但是又没登录则跳转到登录界面
	 */
	private function checkAllowed()
	{
		if ($this->needLogin() and !$this->isLogin())
			$this->redirect(\Func\url('/public/login', true));

		return true;
	}

	/**
	 * 是否需要登录
	 */
	public function needLogin()
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
		
		return $needLogin;	
	}

	public function checkAuth()
	{
	}

	/**
	 * 单页面展示
	 */
	public function single($pagename, $params = [])
	{
		$this->noMainLayout();
		if (!empty($params))
			$this->view->setVars($params);
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
		$this->single('404', $err);
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
			case 'permission':
				$params['msg'] = '无权限';
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

	/**
	 * 分页
	 */
	public function page($count, $limit, $p)
	{
		$page = new \Util\Page($count, $limit, $p);
		return $page->getPage();
	}

	public function limit($p = 1, $pagesize = 1)
	{
		empty($p) and $p = 1;
		$offset = ($p-1) * $pagesize;
		return [$pagesize, $offset];
	}

	public function captcha($width = 85, $height = 35, $color = '', $type = 'tpng')
	{
		\Util\Captcha::make($width, $height, $color, $type);
	}
}
