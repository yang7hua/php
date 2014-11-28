<?php
/**
 * 核查信息
 */
class Check extends Model
{
	public static function baseinfo($uid)
	{
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return [];
		return $info->toArray();
	}

	public function add($data)
	{
		$info = new Check();
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
