<?php

use \Phf\Mvc\Model\Criteria as Criteria;

class Model extends \Phf\Mvc\Model
{
	protected static $db;
	protected function initialize()
	{
		self::$db = $this->getDi()->get('db');
	}

	/**
	 * 添加表前缀
	 */
	public function getSource()
	{
		global $config;
		return $config->database->prefix . strtolower(get_class($this));
	}

	/**
	 * 修改字段url地址
	 */
	public static function baseUrl($url)
	{
		return '/adm/' . ltrim($url, '/');
	}
}
