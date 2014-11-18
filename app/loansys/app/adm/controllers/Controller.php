<?php

class Controller extends \Phf\Mvc\Controller
{
	protected $view = null;

	public function initialize()
	{
		global $view;
		$this->view = $view;
	}

	public function emptyAction()
	{
		echo 'base Controller .';
	}


}
