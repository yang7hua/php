<?php

defined('APP_NAME') or defined('APP_NAME', 'loansys');
define('CONF_PATH', ROOT_PATH . '/config');
define('LIB_PATH', ROOT_PATH . '/lib');

class App 
{
	private static $basefiles = [
		'functions.php',
		'assert.php'
	];
	public static function loadBase()
	{
		foreach (self::$basefiles as $file) {
			$file = LIB_PATH . '/' . $file;
			if (file_exists($file))
				include_once $file;
		}
	}

	/**
	 * 获取所有控制器的权限配置
	 */
	public static function authorities()
	{
		static $authorities = [];

		if (!empty($authorities))
			return $authorities;
		$paths = [
			ADM_NAME	=>	self::getPathByApp(ADM_NAME) . '/controllers',
			FRONT_NAME	=>	self::getPathByApp(FRONT_NAME) . '/Controllers'	
		];

		foreach ($paths as $app=>$path) {
			$files[$app] = glob($path . '/*Controller.php');
		}

		if (!is_array($files) and empty($files))
			return $authorities;

		foreach ($files as $app=>$appfiles) {
			$app_authorities = [];
			foreach ($appfiles as $file) {
				$classname = pathinfo($file)['filename'];
				$newAuthorities = $classname::authorities();
				if (!empty($newAuthorities))
					$app_authorities = array_merge($app_authorities, $newAuthorities);
			}
			$authorities[$app] = $app_authorities;
		}
		return $authorities;

		return $authorities;
	}

	public static function getPathByApp($appname = '')
	{
		return rtrim(ROOT_PATH . '/app/' . ($appname ? $appname . '/' : ''), '/');
	}

	public static function getTextByAppname($appname)
	{
		static $text = [
			'loansys'	=>	'贷款系统',
			'sysadm'	=>	'管理后台'
		];
		return array_key_exists($appname, $text) ? $text[$appname] : null;
	}

	public static function loadRouter(\Phf\Mvc\Router $router)
	{
		$routers = require CONF_PATH . '/router.php';
		foreach ($routers as $key=>$value)
			$router->add($key, $value);
	}

	public function filterMenus($menus)
	{
		global $di;
		$session = $di->get('session');
		foreach ($menus as $key=>$menu) {
			if ($menu['pid'] != 0 and !Authority::actionExist($session->get('o_auth'), $menu['controller'], $menu['action']))
				unset($menus[$key]);
		}
		return $menus;
	}
}

//spl_autoload_register(['App', 'loadClass']);

//include LIB_PATH . '/common.php';

try{
	$config = new Phf\Config\Adapter\Ini(CONF_PATH . '/web.php');
	$config_app = new Phf\Config(include APP_PATH . '/config/config.php');
	$config->merge($config_app);

	App::loadBase();

	$loader = new Phf\Loader();
	$loader->registerDirs(
			array(
				LIB_PATH,
				APP_PATH . '/' . $config->application->controllersDir,
				APP_PATH . '/' . $config->application->modelsDir,
				APP_PATH . '/' . $config->application->libraryDir,
				APP_PATH . '/lib',
				APP::getPathByApp(ADM_NAME) . '/controllers',
				APP::getPathByApp(FRONT_NAME) . '/controllers'
				)
			)
		->registerNamespaces(
				array(
					'Util'	=>	LIB_PATH . '/util',
					'Base'	=>	LIB_PATH . '/base',
					'App'	=>	APP_PATH . '/lib',
					)
				)
		->register();

	//print_r($loader->getNamespaces());
	//echo file_exists(LIB_PATH . '/Common.php');
	//echo class_exists('Util\Common') ? 1 : 0;
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
					'charset'	=>	$config->database->charset,
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
