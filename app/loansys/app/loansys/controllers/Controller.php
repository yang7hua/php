<?php

class Controller extends \Base\Controller
{

	public function initialize()
	{
		parent::initialize();
		if ($this->isLogin()) {
			$o_info = [
				'oid'	=>	$this->session->get('oid'),
				'o_name'	=>	$this->session->get('o_name')
			];
			$this->view->setVar('o_info', $o_info);
		}
	}

	public function isLogin()
	{
		return $this->session->has('oid');
	}
}
