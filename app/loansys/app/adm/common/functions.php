<?php
namespace Common\Func;

use ReflectionClass;

function limit($p=1, $limit=10)
{
	return ($p-1)*$limit . ',' . $limit;
}

function password($password, $salt='zxl')
{
	return md5(md5($password . $salt));
}

function getMethodsOfClass($className)
{
	$class = new ReflectionClass($className);
	return $class->getMethods();
}

function base64url_encode($data) { 
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
} 

function base64url_decode($data) { 
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
} 

function getDate($timestamp=false)
{
	$date = array();
	$date['month_begin'] = date('Y-m-d H:i:s', strtotime(date('Y-m-01')));
	$lastdayofmonth = date('t', time());
	$date['month_end'] = date("Y-m-$lastdayofmonth 23:59:59");
	$date['today_begin'] = date('Y-m-d 00:00:00');
	$date['today_end'] = date('Y-m-d 23:59:59');
	$date['tomorrow_begin'] = date('Y-m-d 00:00:00', strtotime('+1 day'));
	$date['six_month_begin'] = date('Y-m-01 00:00:00', strtotime('-6 month'));

	if($timestamp){
		foreach($date as $key=>$val){
			$date[$key] = strtotime($val);
		}
	}
	return $date;
}

function getExceed($start, $end)
{
	if(empty($end))
		$end = time();
	$diff = $end-$start;
	if($diff <= 0){
		return 0;
	}else{
		$dayseconds = 3600*24;
		$days = ceil($diff/$dayseconds);
	}				
	return $days;
}
