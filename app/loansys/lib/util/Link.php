<?php

namespace Util;

class Link
{
	public static function pageLink($p = 1, $url = '')
	{
		if (empty($url))
		{
			$url = rtrim($_SERVER['REQUEST_URI'], '/');
		}
		if (preg_match('/\d$/', $url))
		{
			$url = substr($url, 0, strrpos($url, '/'));
		}
		return $url . '/' . $p;
	}
}
