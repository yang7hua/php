<?php

class Controller extends \Base\Controller
{
	/**
	 * 检测是否登录
	 */
	public function isLogin()
	{
		return $this->session->get('oid') != null;
	}
}
