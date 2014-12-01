<?php
/**
 * 实地外访 
 */
class Visit extends Model
{
	public static function findByUid($uid)
	{
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return [];
		return $info->toArray();
	}
	
	public function add($data)
	{
		$info = new Visit();
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
