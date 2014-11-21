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


	public static function add($data)
	{
		$model = new self();
		unset($data['repassword']);
		$data['status'] = 1;
		$data['password'] = \Func\password($data['password']);
		return $model->create($data);
	}

	public static function exist($username)
	{
		return self::findFirst("username='$username'");
	}

	public static function edit($oid, $data)
	{
		/*
		if (self::is_super($oid))
			return false;
		 */
		$info = Operator::findFirst($oid);
		foreach ($data as $field=>$value)
			$info->{$field}	=	$value;
		return $info->update();
	}

	private static function is_super($oid)
	{
		return self::SUPER_ID == $oid;
	}

	public static function login($data)
	{
		$rid = Department::getManagerDid();
		$info = self::findFirst("rid=$rid and username='{$data['username']}'");
		if (!$info || $info->password != $data['password'])
			return false;
		return $info;
	}
}
