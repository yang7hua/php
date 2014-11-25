<?php

namespace Base;
//use \Phf\Mvc\Model\Criteria as Criteria;

use Phf\Db\RawValue;

class Model extends \Phf\Mvc\Model
{
	public function getDb()
	{
		return $this->getDi()->get('db');
	}

	protected function rawFields()
	{
		return [];
	}

	public function beforeValidationOnCreate()
	{
		foreach ($this->rawFields() as $field)
			$this->{$field} = new RawValue('default');
	}

	public function beforeValidationOnUpdate()
	{
		foreach ($this->rawFields() as $field)
			$this->{$field} = new RawValue('default');
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
		return \Func\url($url);
	}

	public static function getCriteria()
	{
		static $criteria = null;
		if ($criteria)
			return $criteria;
		$criteria = new \Phf\Mvc\Model\Criteria();
		return $criteria;
	}

	public function outputErrors($model)
	{
		foreach ($model->getMessages() as $row) {
			echo $row->getMessage(),"<br/>";
		}
	}
}
