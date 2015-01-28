<?php

/**
 * 面审相关信息
 */
class Face extends Model
{

	public function getSource()
	{
		global $config;
		return $config->database->prefix . 'userinfo';
	}

	public static function findByUid($uid)
	{
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return [];
		return $info->toArray();
	}

	//复审信息
	public static function refaceInfo($data)
	{
		$fields = [
			'uid', 'amount', 'apr', 'deadline', 'repay_method', 
			'reason', 'risk', 'notice', 'remark', 'uptime'
		];
		foreach ($data as $field=>$value)
		{
			if (!in_array($field, $fields))
				unset($data[$field]);
		}
		if (empty($data['amount']))
			$data = [];
		return $data;
	}

	//初审
	public function _face($uid, $data)
	{
		$uid = intval($uid);
		$info = Face::findFirst("uid=$uid");
		if (!$info) {
			$info = new Face();
			$info->addtime = time();
		}
		$info->uptime = time();
		$info->uid = $uid;
		foreach ($data as $field=>$value)
		{
			$info->$field = $value;
		}
		$result = $info->save();
		if (!$result)
			$this->outputErrors($info);
		return true;

	}

	//复审
	public function reface($uid, $data)
	{
		$uid = intval($uid);
		$info = self::findFirst("uid=$uid");
		if (!$info)
			return false;
		foreach ($data as $field=>$value)
		{
			$info->$field = $value;
		}
		$info->uptime = time();
		$result = $info->update();
		if (!$result)
		{
			$this->outputErrors($info);
			return false;
		}
		return true;
	}

}
