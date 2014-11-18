<?php

defined('APP_NAME') or defined('APP_NAME', 'loansys');
define('CONF_PATH', ROOT_PATH . '/config');
define('LIB_PATH', ROOT_PATH . '/lib');

class App 
{
	public static function loadClass()
	{
	}

	public static function loadRouter(\Phf\Mvc\Router $router)
	{
		$routers = require CONF_PATH . '/router.php';
		foreach ($routers as $key=>$value)
			$router->add($key, $value);
	}
}

try{
	$config = new Phf\Config\Adapter\Ini(CONF_PATH . '/web.php');
	$config_app = new Phf\Config(include APP_PATH . '/config/config.php');
	$config->merge($config_app);

	$loader = new Phf\Loader();
	$loader->registerDirs(
			array(
				LIB_PATH,
				APP_PATH . '/' . $config->application->controllersDir,
				APP_PATH . '/' . $config->application->modelsDir,
				APP_PATH . '/' . $config->application->libraryDir,
				APP_PATH . '/lib'
				)
			)
		->registerNamespaces(
				array(
					'Util'	=>	LIB_PATH
					)
				)
		->register();

	$di = new Phf\DI\FactoryDefault();
	
	/*
	$di->set('voltService', function($view, $di) use ($config){
				$volt = new \Phf\Mvc\View\Engine\Volt($view, $di);
				$volt->setOptions(array(
							//'compiledPath'	=>	rtrim(ROOT_PATH. $config->engine->compiledPath, '/') . '/',
							'compiledExtension'	=>	$config->engine->compiledExtension
						));
				return $volt;
			});
	 */

	$di->set('view', function() use ($config){
			$view = new Phf\Mvc\View();
			$view->setViewsDir(WEB_PATH . '/tpl/' . APP_NAME . '/' . $config->application->default->theme);
			/*
			$view->registerEngines(array(
					'.html'	=>	'voltService'	
					));
			 */
			return $view; 
			});
	$di->set('url', function(){
			$url = new Phf\Mvc\Url();
			$url->setStaticBaseUri('/public/');
			return $url;
			});
	$di->set('db', function() use ($config){
			return new Phf\Db\Adapter\Pdo\Mysql(array(
					'host'	=>	$config->database->host,
					'username'	=>	$config->database->username,
					'password'	=>	$config->database->password,
					'dbname'	=>	$config->database->dbname,
					));	
			});
	$di->setShared('session', function(){
			$session = new Phf\Session\Adapter\Files();
			$session->start();
			return $session;
			});

	$router = new Phf\Mvc\Router();
	$router->setDefaults(array(
				'controller'=>	$config->application->default->controller,
				'action'	=>	$config->application->default->action
				));
	App::loadRouter($router);
	$router->handle();

	include 'app.php';

}catch(Exception $e){

	if(APP_DEBUG){
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		echo $e->getMessage();
	}

}
