<?php

class Repay extends Model
{

	public static function findByUid($uid)
	{
		$uid = intval($uid);
		$list = Repay::query()
			->where("uid=$uid")
			->limit(36)
			->orderBy("no asc")
			->execute()
			->toArray();
		return $list;
	}

}
