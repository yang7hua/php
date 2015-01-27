<?php

$config = [
	'application'	=>	[
		'default'	=>	[
			'controller'	=>	'site',
			'action'	=>	'index',
			'theme'	=>	'default'
		]
	],
	'session'	=>	[
		'expire'	=>	15 * 60//分钟
	],
	'pagination'	=>	[
		'limit'	=>	10
	],
	'database'	=>	[
		'host'	=>	'192.168.1.69',	
		'username'	=>	'loansys_dev',
		'password'	=>	'loansys123mysql.dev.17hao',
		'dbname'	=>	'loansys_dev',
		'charset'	=>	'utf8',
		'prefix'	=>	'sys_'
	]
];

if (defined('APP_ONLINE') and APP_ONLINE)
{
	$config['database'] = [
		'host'	=>	'192.168.1.69',	
		'username'	=>	'loansys_online',
		'password'	=>	'loansys17mysql.17hao.online',
		'dbname'	=>	'loansys_online',
		'charset'	=>	'utf8',
		'prefix'	=>	'sys_'
	];
}

return $config;
