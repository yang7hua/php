<?php

class Advise extends Model
{
	const STATUS_UNDO = 0;
	const STATUS_DO = 1;
	const STATUS_CANCEL = 10;

	public static function add($uid, $oid, $foid, $adviseType, $reason)
	{
		$Advise = new Advise();
		$Advise->uid = $uid;
		$Advise->oid = $oid;
		$Advise->foid = $foid;
		$Advise->type = $adviseType;
		$Advise->reason = $reason;
		$Advise->addtime = time();
		$Advise->status = 0;

		return $Advise->create();
	}

	public static function getAdvisesByOid($oid, $status = 0)
	{
		$oid = intval($oid);
		$condition = "oid=$oid";
		if ($status != '*' and is_numeric($status))
			$condition .= " and status=$status";
		return self::find($condition)->toArray();
	}

	public static function getAdvisesByUid($uid, $status = 0, $type = null)
	{
		$uid = intval($uid);
		$condition = "uid=$uid";
		if ($status !== '*' and is_numeric($status))
			$condition .= " and status=$status";
		if ($type)
			$condition .= " and type='{$type}'"; 

		return self::find($condition)->toArray();
	}

	public static function doAdvises($ids)
	{
		if (strpos($ids, ',') !== false)
			$condition = "id in ($ids)";
		else  
			$condition = "id=$ids";
		$advise = new self;
		return $advise->getDb()->update(
			$advise->getSource(),
			array('status'),
			array(self::STATUS_DO),
			$condition
		);
	}

	public static function formatByType($data)
	{
		$advises = [];
		foreach ($data as $row) {
			if (!array_key_exists($row['type'], $advises))
				$advises[$row['type']] = [];
			$advises[$row['type']][] = $row;
		}
		return $advises;
	}

}
