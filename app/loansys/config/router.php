<?php

return [
	'/'	=>	['controller'=>'site', 'action'=>'index'],
	'/:controller/:action/:params'	=>	['controller' => 1, 'action' => 2, 'params' => 3],
	'/sysadm[/]?'	=>	['controller' => 'index', 'action' => 'index'],	
	'/sysadm/:controller/?'	=>	['controller' => 1, 'action' => 'index'],	
	'/sysadm/:controller/:action/:params'	=>	['controller' => 1, 'action' => 2, 'params' => 3]	
];
