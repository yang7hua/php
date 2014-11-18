<?php

return [
	'/'	=>	['controller'=>'site', 'action'=>'index'],
	'/adm'	=>	['controller' => 'index', 'action' => 'index'],	
	'/adm/:controller'	=>	['controller' => 1, 'action' => 'index'],	
	'/adm/:controller/:action'	=>	['controller' => 1, 'action' => 2]	
];
