<?php

class Validate 
{

	private static $errmsg = array();
	private static $haserr = false;

	private function init()
	{
		self::$errmsg = array();
		self::$haserr = false;
	}

	function check()
	{
		$this->init();
		$args = func_get_args();	

		$validate = array();
		$args = func_get_args();
		if ($args == 1 && is_array($args[0]))
			$validate = $args[0]; 
		else
			$validate[] = $args;	

		foreach ($validate as $row) {
			$value	= array_shift($row);
			$type	= array_shift($row);
			switch ($type) {
				case 'idcard':
					$func = 'isIDCard';
					break;
				case 'email':
					$func = 'isEmail';
					break;
				case 'mobile':
					$func = 'isMobile';
					break;
				case 'telephone':
					$func = 'isTelephone';
					break;
				case 'preg':
					$func = 'preg';
					break;
			}
			$this->vali($func, $value, $row);
		}

		return !self::$haserr;
	}

	function getError()
	{
		return self::$errmsg;
	}

	private function vali($func, $value, $row)
	{
		$params[] = $value;

		$errmsg = $row[0];
		if ($func == 'preg') {
			if (!isset($row[0]))
				return;
			$params[] = $row[0];
			$errmsg = $row[1];
		}
		if (!call_user_func_array(array($this, $func), $params)) {
			self::$errmsg[] = $errmsg;
			self::$haserr = true;
		}
	}

	function isIDCard($value)
	{
		return preg_match('/^([\dxX]{15}|[\dxX]{18})$/', $value);
	}

	function isCh($value)
	{
		return preg_match('/^[\x{4E00}-\x{9Fa5}]+$/u', $value);
	}

	function isEmail($value)
	{
		return preg_match('/^[\w]*@[a-z\d]+\.[a-z\d]+$/', $value);	
	}

	function isMobile($value)
	{
		return preg_match('/^((+86)|(86))?1[3|5|7|8|][0-9]{9}$/', $value);	
	}

	function isTelephone($value)
	{
		return preg_match('/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{8}$/');
	}

	function preg($value, $pattern)
	{
		return preg_match($pattern, $value);
	}

}
