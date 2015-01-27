<?php

class Controller extends \Base\Controller
{

	public function initialize()
	{
		parent::initialize();

		if (!$this->isAjax())
		{
			$sess = $this->getOperator();
			$this->view->setVars([
				'_sess'	=>	$sess
			]);
		}
	}

	/**
	 * 检测是否登录
	 */
	public function isLogin()
	{
		return $this->getOperator();
	}

	public function checkAuth()
	{
	}

	//是否是全国中心操作员
	public function isNationWideBid()
	{
		$bid = $this->getOperatorBid();
		return \App::isNationWideBid($bid);
	}

	public function getOperatorId()
	{
		return $this->getOperator()['aid'];
	}

	public function getOperatorBid()
	{
		return $this->getOperator()['bid'];
	}

	public function getOperator()
	{
		return $this->session->get('adm');
	}

	public function expire()
	{
		return $this->getOperator()['expire'];
	}

	public function logout()
	{
		$this->session->remove('adm');
	}

	/**
	 * 获取所有可配置的权限
	 */
	public function allAuthorities()
	{
		$list = \App\Authority::authorities();
		$isNationWideBid = $this->isNationWideBid();
		$list = \App\Authority::getAuthoriesByBid($list, $isNationWideBid);
		return $list;
	}

}
