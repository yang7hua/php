<?php

/**
 * 后台管理
 * 包括管理员账号、门店管理
 */

class AdmController extends Controller
{
	public function initialize()
	{
		parent::initialize();
		if (!self::isNationWideBid())
			$this->pageError('permission');
	}

}
