<?php

use \Phf\Mvc\Model\Criteria as Criteria;

class Model extends \Phf\Mvc\Model
{
	protected static $db;
	protected function initialize()
	{
		self::$db = $this->getDi()->get('db');
	}

	public function getSource()
	{
		global $config;
		return $config->database->prefix . strtolower(get_class($this));
	}

	public static function baseUrl($url)
	{
		return '/adm/' . ltrim($url, '/');
	}
}
