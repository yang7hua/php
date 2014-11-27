<?php

namespace Func;

function url($url, $host = false)
{
	$base = null;
	if ($host)
		$base .= 'http://' . $_SERVER['SERVER_NAME'];
	if (APP_NAME == ADM_NAME)
		return $base . '/' . APP_NAME . '/' . trim($url, '/');
	return $base . '/' . trim($url, '/');
}

/**
 * 加载js文件到assert中
 * @fresh: true则直接返回
 */
function loadJsFile($filename, $opts = ['depends'=>'\Assert\app'], $appname = 'adm', $fresh = false)
{
	$str = null;

	if (isset($opts['depends']) and is_callable($opts['depends']))
		$str .= $opts['depends']();

	if ($filename) {
		if (strpos($filename, '.') === false)
			$filename .= '.js';

		$file = getJsPath($appname) . '/' . $filename;
		if (!\Assert\loadedStatic($file))
			$str .= '<script type="text/javascript" src="' . $file . '"></script>';
		else
			\Assert\loadedStatic($file, false);
	}

	if ($fresh)
		return $str;
	\Assert\output($str);
}

/**
 * 注册js代码到assert中
 */
function registerJs($jscode)
{
	$code = '<script type="text/javascript">'.$jscode.'</script>';
	\Assert\output($code);
}

function getJsPath($appname = '')
{
	return rtrim(PUBLIC_PATH . '/js/' . $appname, '/');
}

function getCssPath($appname = '')
{
	return rtrim(PUBLIC_PATH . '/css/' . $appname, '/');
}

function password($password, $salt = 'loansys')
{
	return md5(md5($password . $salt));
}

function uniqidByTime()
{
	return date('YmdHis') . mt_rand(1000,9999);
}

function getArrayValue(array $array, $key, $value = false)
{
	if (empty($array) || empty($key))
		return $array;
	if ($value)
	{
		$array = array_flip($array);
	}
	return array_key_exists($key, $array) ? $array[$key] : null;
}

function getArrayKey(array $array, $value)
{
	return getArrayValue($array, $value, true);
}
