<?php
/**
 * 管理后台
 */
namespace app\controllers\sysadm;

class Controller extends \app\controllers\Controller
{

	public $layout = 'sysadm';

	/**
	 * 免登陆
	 */
	protected $publicActions = [
		'public'	=>	'*'
	];

	/**
	 * 主页
	 */
	protected $homePage = '/sysadm/';

	protected $params = [
		'title'	=>	'管理后台'
	];

	public function init()
	{
		parent::init();
		if (!$this->isAjax())
			$this->view->params['_admini']= $this->admini();
		$this->view->params['controller']	=	$this->controllerName();
		$this->view->params['action']	=	$this->actionName();
	}

	public function checkAuth()
	{
		parent::checkAuth();

		if ($this->hasLogin())
			return true;
		if (array_key_exists($this->controllerName(), $this->publicActions))
		{
			if ($this->publicActions[$this->controllerName()] == '*')
				return true;
			if (in_array($this->actionName(), $this->publicActions[$this->controllerName()]))
				return true;
		}
		$this->redirect('public/login');
	}

	public function single($page, $params = [])
	{
		$this->layout = 'sysadm/single';
		return $this->render('/sysadm/single/' . $page, $params);
	}

	public function login($admini)
	{
		$admini = $admini->toArray();
		$admini['expire'] = time() + $this->param('expire');
		unset($admini['password']);
		$this->session->set('admini', $admini);
	}

	public function hasLogin()
	{
		$admini = $this->admini();
		if (!$admini)
			return false;

		if ($admini['expire'] < time())
		{
			$this->logout();
			return false;
		}

		//更新会话时间
		$admini['expire'] = time() + $this->param('expire');
		$this->session->set('admini', $admini);
		return true;
	}

	public function logout()
	{
		$this->session->remove('admini');
	}

	public function admini()
	{
		return $this->session->get('admini');
	}

	public function param($key, $default = '')
	{
		$params = parent::param('sysadm');
		return array_key_exists($key, $params) ? $params[$key] : $default;
	}

	public function redirect($url, $statusCode = 200)
	{
		$url = '/' . $this->appName() . '/' . trim($url, '/');
		return parent::redirect($url, $statusCode);
	}

}
