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
	
	public function _visit($uid, $data)
	{
		$uid = intval($uid);
		$info = Visit::findFirst("uid=$uid");
		if (!$info) {
			$info = new Visit();
			$info->addtime = time();
		}
		$info->uptime = time();
		$result = $info->save($data);
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
