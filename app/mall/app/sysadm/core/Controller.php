<?php

class Controller extends CI_Controller
{

	//管理员ID
	protected $aid = null;

	//无需登录的模块
	protected $public_controllers = [
		'common'	=>	'*',
		'admini'	=>	['login']
	];

	protected $need_check_login = true;

	protected $login_url = '/admini/login';

	function __construct()
	{
		if (isset($_SESSION['admini']))
			$this->aid = $_SESSION['admini']['aid'];
		parent::__construct();
	}

	function has_login()
	{
		return is_null($this->aid) ? false : true;
	}

	function redirect($url)
	{
		$this->load->helper('url');
		redirect(base_url('/sysadm.php?/'.ltrim($url, '/')));
	}

	function go_home()
	{
		$this->redirect('/');
	}

	function url($url, $flag = false)
	{
		if ($flag)
			return base_url($url);
		return base_url('/sysadm.php?'.$url);
	}

}
