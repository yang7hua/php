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

	protected function checkAuth($authkey='adm')
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
