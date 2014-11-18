<?php

class SiteController extends Controller
{
	public function indexAction()
	{
		echo $this->view->getViewsDir();
	}
}
