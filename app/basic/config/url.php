<?php

return [
	'enablePrettyUrl'	=>	true,
	'showScriptName'	=>	false,
	'rules'	=>	[
		'/user/?'	=>	'/user/user/index',
		'/user/<action:(login|reg|logout)>'	=>	'/user/user/<action>',
		//'/user/<controller:[a-z]+>/?'	=>	'/user/<controller>/index',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<do>'	=>	'/user/<controller>/<action>'
	]
];
