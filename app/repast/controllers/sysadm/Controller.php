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
		$this->session->set('admini', $admini);
	}

	public function logout()
	{
		$this->session->remove('admini');
	}

	public function param($key, $default = '')
	{
		$params = parent::param('sysadm');
		return array_key_exists($key, $params) ? $params[$key] : $default;
	}

}
