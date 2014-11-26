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

}
