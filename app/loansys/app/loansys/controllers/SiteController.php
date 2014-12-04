<?php

class SiteController extends Controller
{
	public function indexAction()
	{
		$bid = $this->getOperatorBid();

		if ($this->authHasAction('list', 'rc'))
			$u = 'rc/list';
		else if ($this->authHasAction('list', 'loan'))
			$u = 'loan/list';

		isset($u) and $this->redirect(\Func\url($u, true));
			
		exit();
	}
}
