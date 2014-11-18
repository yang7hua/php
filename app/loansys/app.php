<?php

set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);

$controllerName = $router->getControllerName();
$actionName = $router->getActionName();

$controller = ucwords($controllerName) . 'Controller';

if(!class_exists($controller)) 
	throw new Exception('Controller '.$controller.' not exists!');

$reflectionController = new ReflectionClass($controller);

$dispatcher = $di->get('dispatcher');
$reflectionController->hasMethod($actionName . 'Action') or	$actionName = 'empty';	

$dispatcher->setControllerName($controllerName);
$dispatcher->setActionName($actionName);
$dispatcher->setParams($router->getParams());

$view = $di->get('view');
$view->start();

$dispatcher->dispatch();

$view->render($controllerName, $actionName); 
$view->finish();

$response = $di['response'];
$response->setContent($view->getContent());
$response->sendHeaders();
exit($response->getContent());
