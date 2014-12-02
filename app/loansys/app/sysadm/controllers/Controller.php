<?php

class Controller extends \Base\Controller
{
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

	public function initialize()
	{
		parent::initialize();
		$sess = $this->session->get('adm');
		$this->view->setVars([
				'_sess'	=>	$sess
			]);
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

	/**
	 * 获取所有可配置的权限
	 */
	public function allAuthorities()
	{
		$list = Authority::all();
		$isNationWideBid = $this->isNationWideBid();
		$list = \App\Authority::getAuthoriesByBid($list, $isNationWideBid);
		return $list;
	}

}
