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
		$uid = intval($data['uid']);
		$info = Car::findFirst("uid=$uid");
		$exist = $info ? true : false;
		foreach ($data as $field=>$value)
		{
			$info->$field = $value;
		}
		if (!$exist)
			$info->addtime = time();
		$info->uptime = time();
		$result = $info->save();
		if (!$result) 
		{
			$this->outputErrors($info);
			return false;
		}
		return true;

	}

	public static function hasDone($uid)
	{
		$car = Car::findFirst("uid=$uid");
		if (!$car)
			return false;
		$advises = Advise::getAdvisesByUid($uid, Advise::STATUS_UNDO, 'car');
		return $advises ? false : true;
	}

}
