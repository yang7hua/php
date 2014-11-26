<?php

class Branch extends Model
{
	public static function all($options = [])
	{
		$condition = (is_array($options) and $options['all']) ? '' : self::baseCondition();
		$list = Branch::find($condition);
		if ($list)
		{
			$list = $list->toArray();
			if (is_array($options) and $options['key']) {
				$data = [];
				foreach ($list as $row)
					$data[$row['bid']] = $row;
				$list = $data;
			}
			return $list;
		}
		return [];
	}

	public static function add($data)
	{
		$Branch = new Branch();
		foreach ($data as $field=>$value)
		{
			$Branch->$field = $value;
		}
		return $Branch->save();
	}

	/**
	 * 用于select选项
	 */
	public static function options($params = [])
	{
		$options = [];	
		//global $di;
		//echo $di->get('session')->get('bid');

		$list = self::all($params);
		if ($list) {
			foreach ($list as $row) {
				array_push($options, [
					'value'	=>	$row['bid'],
					'name'	=>	$row['name']
				]);
			}
		}
			
		return $options;	
	}

	public static function findById($id)
	{
		$info = Branch::findFirst(intval($id));
		if ($info)
			return $info->toArray();
		return null;
	}

	public static function editById($id, $data)
	{
		$info = Branch::findFirst(intval($id));
		if (!$info)
			return false;
		foreach ($data as $field=>$value)
		{
			$info->$field = $value;
		}
		return $info->update();
	}
}
