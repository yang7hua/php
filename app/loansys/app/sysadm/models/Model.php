<?php

class Model extends \Base\Model
{

	public static function isSuperBid($bid = '')
	{
		return \App::isSuperBid($bid);
	}

	public static function baseCondition()
	{
		$bid = \App::session('bid', 'adm');
		if (!$bid)
			return '';
		return "bid=$bid";
	}
}
