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
		if (!self::isSuperBid())
			$this->pageError('permission');
	}

	public static function isSuperBid()
	{
		return \App::session('bid', 'adm') == 1;
	}
}
