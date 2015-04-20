<?php

namespace Util;

class Validator
{

	static function isIDCard($value)
	{
		return preg_match('/^([\dxX]{15}|[\dxX]{18})$/', $value);
	}

	static function isCh($value)
	{
		return preg_match('/^[\x{4E00}-\x{9Fa5}]+$/u', $value);
	}

	static function isEmail($value)
	{
		return preg_match('/^[\w]*@[a-z\d]+\.[a-z\d]+$/', $value);	
	}

	static function isMobile($value)
	{
		return preg_match('/^((+86)|(86))?1[3|5|7|8|][0-9]{9}$/', $value);	
	}

	static function isTelephone($value)
	{
		return preg_match('/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{8}$/');
	}

	static function preg($value, $pattern)
	{
		return preg_match($pattern, $value);
	}

	static function isNumber($value)
	{
		return preg_match('/^\d+$/', $value);
	}

	static function isUname($value)
	{
		return preg_match('/^[\w_]+$/', $value);
	}

}
