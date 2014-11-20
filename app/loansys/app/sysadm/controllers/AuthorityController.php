<?php

class AuthorityController extends Controller
{
	
	public function listAction()
	{
		$list = Authority::all();
	}

	public function addAction()
	{
	}

}
