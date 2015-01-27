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
		$uid = intval($data['uid']);
		$info = Visit::findFirst("uid=$uid");
		$exist = false;
		if ($info)
			$exist = true;
		foreach ($data as $field=>$value) {
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
		$visit = Visit::findFirst("uid=$uid");
		if (!$visit)
			return false;
		$advises = Advise::getAdvisesByUid($uid, Advise::STATUS_UNDO, 'visit');
		return $advises ? false : true;
	}
}
