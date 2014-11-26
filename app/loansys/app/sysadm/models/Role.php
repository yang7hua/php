<?php

class Role extends Model
{
	public static function findById($rid)
	{
		$info = self::findFirst($rid)->toArray();
		return self::format($info, true);
	}

	public static function all($withKey = false)
	{
		$list = self::find(self::baseCondition())->toArray();
		if ($list and $withKey) {
			$data = [];
			foreach ($list as $row)
				$data[$row['rid']] = $row;
			$list = $data;
		}
		return self::format($list);
	}

	public static function format(array $data = [], $single = false)
	{
		$departments = Department::all(true);
		if ($single)
			$data = [$data];
		foreach ($data as &$row) {
			$row['dname'] = $departments[$row['did']]['name'];
		}
		return $single ? $data[0] : $data;
	}

	public static function add($data)
	{
		$model = new self();
		$data['pid'] = 0;
		$data['auth'] = ' ';
		return $model->create($data);
	}

	/**
	 * 用于select选项
	 */
	public static function options()
	{
		$options = [];	

		$list = self::all();
		if ($list) {
			foreach ($list as $row) {
				array_push($options, [
					'value'	=>	$row['rid'],
					'name'	=>	$row['name']
				]);
			}
		}
		
		return $options;	
	}

	public static function edit($rid, $data)
	{
		$info = Role::findFirst($rid);
		foreach ($data as $field=>$value)
			$info->{$field}	=	$value;
		return $info->update();
	}
}
