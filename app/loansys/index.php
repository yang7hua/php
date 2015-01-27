<?php

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
	 * 通过app名称获取路径
	 */
	public static function getPathByApp($appname = '')
	{
		return rtrim(ROOT_PATH . '/app/' . ($appname ? $appname . '/' : ''), '/');
	}

	public static function getTextByAppname($appname)
	{
		static $text = [
			FRONT_NAME	=>	'贷款系统',
			ADM_NAME	=>	'管理后台'
		];
		return array_key_exists($appname, $text) ? $text[$appname] : null;
	}

	public static function loadRouter(\Phf\Mvc\Router $router)
	{
		$routers = require CONF_PATH . '/router.php';
		foreach ($routers as $key=>$value)
			$router->add($key, $value);
	}

	public static function session($key = '', $app = '')
	{
		$session = $app ? $_SESSION[$app] : $_SESSION;
		if (!$session)
			return null;
		if ($key and array_key_exists($key, $session))
			return $session[$key];
		return $session;
	}

	/**
	 * 判断是否是全国总店账号
	 */
	public static function isNationWideBid($bid = '')
	{
		if (empty($bid))
			$bid = self::session('bid', 'adm');
		return $bid == 1;
	}

}

try{
	$config = new Phf\Config(include CONF_PATH . ($_SERVER['HTTP_HOST'] == 'loan.local.com' ? '/web_local.php' : '/web.php'));
	$config_app = new Phf\Config(include APP_PATH . '/config/config.php');
	$config->merge($config_app);

	App::loadBase();

	$loader = new Phf\Loader();
	$loader->registerDirs(
			array(
				LIB_PATH,
				APP_PATH . '/controllers',
				APP_PATH . '/models',
				APP_PATH . '/lib',
				APP_PATH . '/lib/config',
				APP::getPathByApp(ADM_NAME) . '/controllers',
				APP::getPathByApp(FRONT_NAME) . '/controllers'
				)
			)
		->registerNamespaces(
				array(
					'Util'	=>	LIB_PATH . '/util',
					'Base'	=>	LIB_PATH . '/base',
					'App'	=>	APP_PATH . '/lib',
					'App\Config'	=>	APP_PATH . '/lib/config',
					'Apps'	=>	LIB_PATH	
					)
				)
		->register();

	$di = new Phf\DI\FactoryDefault();
	
	$di->set('view', function() use ($config){
			$view = new \Base\View();
			$view->setViewsDir(WEB_PATH . '/tpl/' . APP_NAME . '/' . $config->application->default->theme);
			return $view; 
			});
	$di->set('url', function(){
			$url = new Phf\Mvc\Url();
			$url->setBaseUri('/');
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
