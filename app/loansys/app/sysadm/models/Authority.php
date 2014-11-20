<?php

class Authority extends Model
{
	public static function all()
	{
		$list = self::find()->toArray();
		return $list;
	}

}
