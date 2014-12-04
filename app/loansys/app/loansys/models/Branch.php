<?php

class Branch extends Model
{
	public static function getNameById($id)
	{
		$info = self::findFirst(intval($id));
		if (!$info)
			return null;
		return $info->name;
	}

	public static function options()
	{
		static $options = [];
		if (!empty($options))
			return $options;

		$options[0] = '所有门店';
		$branches = self::find()->toArray();
		foreach ($branches as $row)
		{
			if (\App::isNationWideBid($row['bid']))
				continue;
			$options[$row['bid']] = $row['name'];
		}

		return $options;
	}
}
