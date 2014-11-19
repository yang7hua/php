<?php

class Department extends Model
{
	public static function all()
	{
		return [
			['value'=>0, 'name'=>'顶级']
		];
	}
}
