<?php

return [
	'enablePrettyUrl'	=>	true,
	'showScriptName'	=>	false,
	'rules'	=>	[
		'/user/<controller:[a-z]+>'	=>	'/user/<controller>',
		'/user/<controller:[a-z]+>/<action:[a-z]+>(/[\d]+)?'	=>	'/user/<controller>/<action>',
		'/<controller:[a-z]+>/<action:[a-z]+>'	=>	'/site/<controller>/<action>',
	]
];
