<?php

namespace App\Config;

class Company 
{
	public static function status()
	{
		return [
			1	=>	'正常',
			20	=>	'筹备',
			30	=>	'暂停营业',
			50	=>	'关门'		
		];
	}
}
