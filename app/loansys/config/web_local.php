<?php

return [
	'application'	=>	[
		'default'	=>	[
			'controller'	=>	'site',
			'action'	=>	'index',
			'theme'	=>	'default'
		]
	],
	'session'	=>	[
		'expire'	=>	1 * 60//分钟
	],
	'pagination'	=>	[
		'limit'	=>	10
	],
	'database'	=>	[
		'host'	=>	'localhost',	
		'username'	=>	'root',
		'password'	=>	'mysql',
		'dbname'	=>	'loansys',
		'charset'	=>	'utf8',
		'prefix'	=>	'sys_'
	]
];
