<?php

class SiteController extends Controller
{
	public function indexAction()
	{
		$this->autoGuide();	
		exit();
	}

	/**
	 * 自动引导主页面
	 */
	private function autoGuide()
	{
		$bid = $this->getOperatorBid();

		if ($this->authHasAction('list', 'rc'))
			$u = 'rc/list';
		else if ($this->authHasAction('list', 'loan'))
			$u = 'loan/list';
		else if ($this->authHasAction('list', 'supervisor'))
			$u = 'supervisor/list';
		else if ($this->authHasAction('list', 'gps'))
			$u = 'gps/list';
		else if ($this->authHasAction('list', 'finance'))
			$u = 'finance/list';

		isset($u) and $this->redirect(\Func\url($u, true));
	}
}
