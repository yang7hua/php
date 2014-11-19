<?php

namespace Func;

/**
 * 加载js文件到assert中
 * @fresh: true则直接返回
 */
function loadJsFile($filename, $opts = [], $appname = 'adm', $fresh = false)
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
