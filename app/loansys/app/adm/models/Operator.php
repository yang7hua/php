<?php

class Operator extends Model
{
	public static function all()
	{
		$list = self::find()->toArray();

		return self::format($list);
	}

	public static function format($data)
	{
		$roles = Role::all(true);
		foreach ($data as &$row) {
			$role = $roles[$row['rid']];
			$row['rname'] = $role['name'];
			$row['dname'] = $role['dname'];
		}
		return $data;
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
}
