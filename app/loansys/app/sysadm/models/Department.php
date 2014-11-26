<?php

class Department extends Model
{
	public static function findById($id)
	{
		$info = self::findFirst($id)->toArray();
		return $info;
	}

	public static function all($withKey = false)
	{
		$list = self::find(self::baseCondition())->toArray();

		if ($list and $withKey) {
			$data = [];
			foreach ($list as $row)	
				$data[$row['did']] = $row;
			return $data;
		}

		return $list;
	}

	/**
	 * 用于select选项
	 */
	public static function options($withdefault = false)
	{
		$default = [
			['value'=>0, 'name'=>'顶级']
		];
		$options = [];	

		if ($withdefault)
			$options = array_merge($options, $default);

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

	public static function add($data)
	{
		$model = new self();
		$data['pid'] = 0;
		return $model->create($data);
	}

	public static function edit($id, $data)
	{
		$info = Department::findFirst($id);
		if (!$info)
			return false;
		foreach ($data as $field=>$value)
			$info->{$field}	=	$value;
		return $info->update();
	}

}
