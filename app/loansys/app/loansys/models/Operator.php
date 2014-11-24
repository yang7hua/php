<?php

class Operator extends Model
{
	const SUPER_ID = 1;

	public static function findById($oid)
	{
		$info = self::findFirst($oid)->toArray();
		return self::format($info, true);
	}

	public static function all()
	{
		$list = self::find()->toArray();

		return self::format($list);
	}

	public static function getAuthByRid($rid)
	{
		$role = Role::findById($rid);
		return unserialize($role['auth']);
	}

	public static function format($data, $single = false)
	{
		$roles = Role::all(true);
		if ($single)
			$data = [$data];
		foreach ($data as $key=>&$row) {
			if (self::is_super($row['oid']))
				unset($data[$key]);
			$role = $roles[$row['rid']];
			$row['rname'] = $role['name'];
			$row['dname'] = $role['dname'];
		}
		return $single ? $data[0] : $data;
	}

	private static function is_super($oid)
	{
		return self::SUPER_ID == $oid;
	}

	public static function login($data)
	{
		$info = self::findFirst("username='{$data['username']}'");
		if (!$info || $info->password != $data['password'])
			return false;
		return $info;
	}
}
