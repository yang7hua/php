<?php

return [
	'enablePrettyUrl'	=>	true,
	'showScriptName'	=>	false,
	'rules'	=>	[
		'/blog/<id:\d+>'	=>	'/blog/detail',
		'/topic/<topic:[\w]+>'	=>	'/blog/topic',
		'/topic/<topic:[\w]+>/<page:[\d]+>'	=>	'/blog/topic',
		//'/topic/<topic:[\w]+>/?page=<page:\d+>'	=>	'/blog/topic/<page>',
		'/user/'	=>	'/user/user/index',
		'/user/<action:(login|reg|logout)>'	=>	'/user/user/<action>',
		'/user/site/<code:[a-z]+>'	=>	'/user/site',
		'/user/site/<code:[a-z]+>/<do:[a-z]+>'	=>	'/user/site',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<do:[a-z]+>'	=>	'/user/<controller>/<action>',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<id:\d+>'	=>	'/user/<controller>/<action>'
	]
];
