<?php

namespace App;

class Func
{
	static function needFace($status)
	{
		$status_face = \Func\getArrayKey(\App\Config\Loan::status(), '初审');
		return $status < $status_face;
	}

	static function needVisit($status)
	{
		$status_face = \Func\getArrayKey(\App\Config\Loan::status(), '初审');
		$status_checked = \Func\getArrayKey(\App\Config\Loan::status(), '已核查');
		return $status >= $status_face and $status < $status_checked;
	}
}
