<?php

class Model extends \Base\Model
{

	public static function isNationWideBid($bid = '')
	{
		return \App::isNationWideBid($bid);
	}

	public static function baseCondition()
	{
		$bid = \App::session('bid', 'adm');
		if (!$bid)
			return '';
		return "bid=$bid";
	}
}
