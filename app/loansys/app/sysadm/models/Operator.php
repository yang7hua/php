<?php

class Operator extends Model
{
	const SUPER_ID = 1;

	public static function findById($oid)
	{
		$info = self::findFirst($oid)->toArray();
		return self::format($info, true);
	}

	public static function findByUsername($username)
	{
		$where = "username='$username'";
		$info = Operator::query()
					->where($where)
					->leftJoin('Role', 'Role.rid=Operator.rid')
					->leftJoin('Department', 'D.did=Operator.did', 'D')
					->leftJoin('Branch', 'B.bid=Operator.bid', 'B')
					->columns('Operator.oid, Operator.username, Operator.password,
						Role.rid, Role.name rname,
						D.did, D.name dname,
						B.bid, B.name bname')
					->limit(1)
					->execute();
		if (!$info)
			return null;
		return $info->toArray()[0];
	}

	public static function all()
	{
		$list = self::find(self::baseCondition())->toArray();
		return self::format($list);
	}

	public static function format($data, $single = false)
	{
		$roles = Role::all(true);
		if ($single)
			$data = [$data];
		foreach ($data as $key=>&$row) {
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
		$info = self::findByUsername($data['username']);
		if (!$info || $info['password'] != $data['password'])
			return false;
		unset($info['password']);
		return $info;
	}
}
