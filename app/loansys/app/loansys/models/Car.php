<?php
/**
 * 车评 
 */
class Car extends Model
{

	public function getSource()
	{
		global $config;
		return $config->database->prefix . 'car_assess';
	}

	public static function findByUid($uid)
	{
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return [];
		return $info->toArray();
	}
	
	public function add($data)
	{
		$info = new Car();
		foreach ($data as $field=>$value)
		{
			$info->$field = $value;
		}
		$result = $info->create();
		if (!$result) 
		{
			$this->outputErrors($info);
			return false;
		}
		return true;

	}
}
