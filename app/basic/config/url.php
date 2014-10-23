<?php

return [
	'enablePrettyUrl'	=>	true,
	'showScriptName'	=>	false,
	'rules'	=>	[
		'/blog/<id:\d+>'	=>	'/blog/detail',
		'/topic/<topic:[\w]+>'	=>	'/blog/topic',
		'/user/?'	=>	'/user/user/index',
		'/user/<action:(login|reg|logout)>'	=>	'/user/user/<action>',
		'/user/site/<code:[a-z]+>'	=>	'/user/site',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<do:[a-z]+>'	=>	'/user/<controller>/<action>',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<id:\d+>'	=>	'/user/<controller>/<action>'
	]
];
