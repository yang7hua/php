<?php

class Repay extends Model
{

	public static function format($data)
	{
		foreach ($data as &$row)
		{
			if ($row['date'])
				$row['date_text'] = date('Y-m-d', $row['date']);
			else
				$row['date_text'] = '--';
			$row['status_text'] = $row['status'] == 1 ? '正常还款' : '已逾期';
			$row['amount'] = str_replace('.00', '', $row['amount']);
		}
		return $data;
	}

	public static function findByUid($uid)
	{
		$uid = intval($uid);
		$list = Repay::query()
			->where("uid=$uid")
			->limit(36)
			->orderBy("no asc")
			->execute()
			->toArray();
		return self::format($list);
	}

	//添加还款记录
	public static function add($data)
	{
		$repay = new Repay();
		foreach ($data as $field=>$value)
		{
			$repay->$field = $value;
		}
		if ($repay->create())
			return true;
		$repay->outputErrors($repay);
		return false;
	}

	public static function doRepay($id, $data)
	{
		$repay = Repay::findFirst($id);
		if (!$repay)
			return false;
		foreach ($data as $field=>$value)
		{
			$repay->$field = $value;
		}
		if ($repay->update())
			return true;
		$repay->outputErrors($repay);
		return false;
	}

}
