<?php

class Controller extends \Base\Controller
{
	/**
	 * 检测是否登录
	 */
	public function isLogin()
	{
		return $this->session->get('adm_id') != null;
	}

	protected function checkAuth($authkey='adm_auth')
	{
		parent::checkAuth($authkey);
	}
}
