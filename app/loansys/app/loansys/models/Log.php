<?php

/**
 * 贷款相关操作日志
 */
class Log extends Model
{
	public static function add($uid, $oid, $info)
	{
		$Log = new Log();
		$Log->uid = $uid;
		$Log->oid = $oid;
		$Log->info = $info;
		$Log->addtime = time();
		if ($Log->create())	
			return true;
		$Log->outputErrors($Log);
		return false;
	}
}
