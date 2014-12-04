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
		if (($pos = strpos($url, '?')) != false)
		{
			$query_str = substr($url, $pos);
			$url = substr($url, 0, $pos);
		}
		if (preg_match('/\d$/', $url))
		{
			$url = substr($url, 0, strrpos($url, '/'));
		}

		$url = $url . '/' . $p;
		if (isset($query_str))
			$url .= $query_str;
		return $url;
	}
}
