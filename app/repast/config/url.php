<?php

return [
	'enablePrettyUrl'	=>	true,
	'showScriptName'	=>	false,
	'rules'	=>	[
		'/site/<action:[a-z]+>'	=>	'/site/<action>',

		'/user/<controller:[a-z]+>'	=>	'/user/<controller>',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/([\d]+)?'	=>	'/user/<controller>/<action>',

		'/sysadm/?'	=>	'/sysadm/index',
		'/sysadm/<controller:[a-z]+>'	=>	'/sysadm/<controller>',
		'/sysadm/<controller:[a-z]+>/<action:[a-z]+>'	=>	'/sysadm/<controller>/<action>',
		'/sysadm/<controller:[a-z]+>/<action:[a-z]+>/<id:[\d]+>'	=>	'/sysadm/<controller>/<action>',

		'/<controller:[a-z]+>/<action:[a-z]+>/?'	=>	'/site/<controller>/<action>',
		'/<controller:[a-z]+>/<action:[a-z]+>/<id:[\d]+>'	=>	'/site/<controller>/<action>',
	]
];
