<?php

class Admini extends Model
{

	const STATUS_NORMAL = 1;
	const STATUS_FREEZE = 10;

	public static function exist($username)
	{
		return self::findFirst("username='$username'");
	}

	public static function all()
	{
		$list = self::find();
		if (!$list)
			return [];
		return self::format(self::filter($list->toArray()));
	}

	public static function findById($id)
	{
		$info = self::findFirst(intval($id));
		if (!$info)
			return null;
		return self::format([$info->toArray()])[0];
	}

	private static function filter($data)
	{
		foreach ($data as $key=>$row)
		{
			if ($row['issuper'])
				unset($data[$key]);
		}
		return $data;
	}

	private static function format($data)
	{
		$branches = Branch::all(['key'=>true, 'all'=>true]);

		foreach ($data as $key=>&$row)
		{
			$row['bname'] = $branches[$row['bid']]['name'];
			$row['is_freeze'] = $row['status'] == self::STATUS_FREEZE;
			$row['status_text'] = $row['is_freeze'] ? '已冻结' : '正常';
		}
		return $data;
	}

	public static function findByUsername($username)
	{
		$info = self::findFirst("username='$username'");
		if (!$info)
			return null;
		$info = $info->toArray();
		return self::format([$info])[0];
	}

	public static function login($data)
	{
		$info = self::findByUsername($data['username']);
		if (!$info || $info['password'] != $data['password'])
			return false;
		unset($info['password']);
		return $info;
	}

	public static function edit($oid, $data)
	{
		$info = Admini::findFirst($oid);
		foreach ($data as $field=>$value)
			$info->{$field}	=	$value;
		return $info->update();
	}

	public static function add($data)
	{
		$model = new self();
		unset($data['repassword']);
		$data['status'] = 1;
		$data['issuper'] = 0;
		return $model->create($data);
	}
}
