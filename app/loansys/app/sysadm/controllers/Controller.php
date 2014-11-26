<?php

class Controller extends \Base\Controller
{
	/**
	 * 检测是否登录
	 */
	public function isLogin()
	{
		return $this->session->get('adm') != null;
	}

	public function checkAuth()
	{
	}

	public function initialize()
	{
		parent::initialize();
		$sess = $this->session->get('adm');
		$this->view->setVars([
				'_sess'	=>	$sess
			]);
	}
}
