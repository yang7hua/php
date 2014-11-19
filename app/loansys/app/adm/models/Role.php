<?php

class Role extends Model
{
	public static function all($withKey = false)
	{
		$list = self::find()->toArray();

		if ($list and $withKey) {
			$data = [];
			foreach ($list as $row)
				$data[$row['rid']] = $row;
			$list = $data;
		}
		return self::format($list);
	}

	public static function format(array $data = [])
	{
		$departments = Department::all(true);
		foreach ($data as &$row) {
			$row['dname'] = $departments[$row['did']]['name'];
		}
		return $data;
	}

	public static function add($data)
	{
		$model = new self();
		$data['pid'] = 0;
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
					'value'	=>	$row['did'],
					'name'	=>	$row['name']
				]);
			}
		}
		
		return $options;	
	}
}
