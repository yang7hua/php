<?php

/**
 * GPS、合同签署、车钥匙、抵押公证
 */
class AfterRcController extends Controller
{

	public function initialize()
	{
		parent::initialize();
		$this->afterRcAuthes();
	}

	/**
	 * 是否具有GPS、合同签署、车钥匙、抵押公证权限
	 * 如果有，则输出到模板变量 
	 */
	public function afterRcAuthes()
	{
		$authes = $this->getOperatorAuth();
		$_actions = ['gps', 'contract', 'carkey', 'pledgenotary'];
		$_all_actions = [];
		foreach ($authes as $controller=>$actions) {
			$_all_actions = array_merge($_all_actions, $actions);
		}
		$authes = array_intersect($_actions, $_all_actions);
		if (!empty($authes)) {
			$this->view->setVars([
				'auth_actions'	=>	$authes
			]);
		}
	}

}
