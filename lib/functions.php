<?php

function ajaxReturn($data, $success = true)
{
	$return = array();
	$return['ret'] = $success ? 1 : 0;
	if($success){
		if(is_string($data))
			$return['msg'] = $data;
		else if(is_array($data))
			$return['data'] = $data;
	} else {
		$return['msg'] = $data;
	}
	exit(json_encode($return));
}


function unescape($str) 
{ 
	$ret = ''; 
	$len = strlen($str); 
	for ($i = 0; $i < $len; $i ++) 
	{ 
		if ($str[$i] == '%' && $str[$i + 1] == 'u') 
		{ 
			$val = hexdec(substr($str, $i + 2, 4)); 
			if ($val < 0x7f) 
				$ret .= chr($val); 
			else  
				if ($val < 0x800) 
					$ret .= chr(0xc0 | ($val >> 6)) . 
					chr(0x80 | ($val & 0x3f)); 
				else 
					$ret .= chr(0xe0 | ($val >> 12)) . 
					chr(0x80 | (($val >> 6) & 0x3f)) . 
					chr(0x80 | ($val & 0x3f)); 
			$i += 5; 
		} else  
			if ($str[$i] == '%') 
			{ 
				$ret .= urldecode(substr($str, $i, 3)); 
				$i += 2; 
			} else 
				$ret .= $str[$i]; 
	} 
	return $ret; 
}

function isImg($filename)
{
	return in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), ['jpg', 'gif', 'png', 'jpeg']);
}

function formatMoney($money, $decimals = 2, $separator = ',', $decimalpoint = '.')
{
	return number_format($money, $decimals, $decimalpoint, $separator);
}


function getDawnByDate($date = null)
{
	if ($date === 0)
		return null;
	$today = strtotime(date('Y-m-d 00:00:00'));
	switch ($date) {
	case 1:
		return strtotime('-1 day', $today);
		break;
	case 3:
		return strtotime('-3 day', $today);
		break;
	case 7:
		return strtotime('-7 day', $today);
		break;
	case 'm':
		return strtotime('-1 month', $today);
		break;
	default:
		return null;
		break;
	}
}

function ip()
{
	$ip = null;
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')) 
		$ip = getenv('HTTP_CLIENT_IP'); 
	elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown'))
		$ip = getenv('HTTP_X_FORWARDED_FOR'); 
	elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'),'unknown'))
		$ip = getenv('REMOTE_ADDR'); 
	elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown'))
		$ip = $_SERVER['REMOTE_ADDR']; 
	
	return $ip;
}

function getUserAgent()
{
	return $_SERVER['HTTP_USER_AGENT'];
}

function getClientOs()
{
	$agent = getUserAgent();
	$os = null;  
	if(stristr($agent, 'win 9x') && stripos($agent,"4.90"))  
		$os = 'Windows ME';  
	else if (stristr($agent, 'win')) {  
		if (stristr($agent, '95'))
			$os = 'Windows 95';  
		else if(stristr($agent, 98))  
			$os = 'Windows 98';  
		else if(stristr($agent, 'nt 5.1'))  
			$os = 'Windows XP';  
		else if(stristr($agent, 'nt 5'))  
			$os = 'Windows 2000';  
		else if(stristr($agent, 'nt'))  
			$os = 'Windows NT';  
		else if(stristr($agent, '32'))  
			$os = 'Windows 32';  
		else 
			$os = 'Windows';
	} else if(stristr($agent, 'linux'))  
		$os = 'Linux';  
	else if(stristr($agent, 'unix'))  
		$os = 'Unix';  
	else if(stristr($agent, 'sun') && stristr($agent, 'os'))  
		$os = 'SunOS';  
	else if(stristr($agent, 'ibm') && stristr($agent, 'os'))
		$os = 'IBM OS/2';  
	else if(stristr($agent, 'mac'))  
		$os = 'Macintosh';  
	else if(stristr($agent, 'powerpc'))  
		$os = 'PowerPC';  
	else if(stristr($agent, 'aix'))  
		$os = 'AIX';  
	else if(stristr($agent, 'HPUX'))  
		$os = 'HPUX';  
	else if(stristr($agent, 'netbsd'))  
		$os = 'NetBSD';  
	else if(stristr($agent, 'bsd'))
		$os = 'BSD';  
	else if(stristr($agent, 'OSF1'))  
		$os = 'OSF1';  
	else if(stristr($agent, 'IRIX'))
		$os = 'IRIX';  
	else if(stristr($agent, 'FreeBSD'))
		$os = 'FreeBSD';  
	else if(stristr($agent, 'teleport'))  
		$os = 'teleport';  
	else if(stristr($agent, 'flashget'))
		$os = 'flashget';  
	else if(stristr($agent, 'webzip'))  
		$os = 'webzip';  
	else if(stristr($agent, 'offline'))
		$os = 'offline';  
	else  
		$os = 'Unknown';  

	return $os;  
}

function getBrowser()
{
	$agent = getUserAgent();

	$browser = 'unknown';
	$version = 'unknown';

	if ($agent) {
		if (strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
			$browser = 'ie';
		else if(strpos($agent,'Firefox')!==false)
			$browser = 'firefox';
		else if(strpos($agent,'Chrome')!==false)
			$browser = 'chrome';
		else if(strpos($agent,'Opera')!==false)
			$browser = 'opera';
		else if((strpos($agent,'Chrome')==false) && strpos($agent,'Safari')!==false)
			$browser = 'safari';

		if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
			$version = $regs[1];
		elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
			$version = $regs[1];
		elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
			$version = $regs[1];
		elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
			$version = $regs[1];
		elseif ((strpos($agent,'Chrome')==false) && preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
			$version = $regs[1];
	}

	return [
		'browser'	=>	ucfirst($browser),
		'version'	=>	$version
	];
}

function getIpArea($ip = null)
{
	$ip or $ip = getIp();
	$ch = curl_init('http://ipapi.sinaapp.com/api.php?f=json&ip=' . $ip);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($ch);
	if (!$res)
		return curl_error($ch);
	curl_close($ch);
	$res = json_decode($res);
	$f = fopen('data/ip.txt', 'a+');
	fwrite($f, $ip . '#' . $res->area1 . "\n");
	fclose($f);
	return [
		'ip'	=>	$ip,
		'area'	=>	$res->area1
	];
}

function getGenderByIDCard($idcard)	
{
	if (!preg_match('/^[\dxX]+$/', $idcard))
		return 0;
	$strlen = strlen($idcard);
	if ($strlen == 15) {
		return substr($idcard, 14)%2 == 0 ? 2 : 1;
	}
	if ($strlen == 18) {
		return substr($idcard, 16, 1)%2 == 0 ? 2 : 1;
	}
	return 0;
}

function getAgeByIDCard($idcard)
{
	$strlen = strlen($idcard);
	if ($strlen != 15 and $strlen != 18)
		return 0;
	if ($strlen == 15)
		$birthday = substr($idcard, 6, 6);
	else 
		$birthday = substr($idcard, 6, 8);
	$age = floor((time() - strtotime($birthday))/31104000);
	return $age > 0 ? $age : 0;
}

function getProvinceByIDCard($idcard)
{
	$provinces = array(
		'11'	=>	'北京市',
		'12'	=>	'天津市',
		'13'	=>	'河北省',
		'14'	=>	'山西省',
		'15'	=>	'内蒙古自治区',
		'21'	=>	'辽宁省',
		'22'	=>	'吉林省',
		'23'	=>	'黑龙江省',
		'31'	=>	'上海市',
		'32'	=>	'江苏省',
		'33'	=>	'浙江省',
		'34'	=>	'安徽省',
		'35'	=>	'福建省',
		'36'	=>	'江西省',
		'37'	=>	'山东省',
		'41'	=>	'河南省',
		'42'	=>	'湖北省',
		'43'	=>	'湖南省',
		'44'	=>	'广东省',
		'45'	=>	'广西壮族自治区',
		'46'	=>	'海南省',
		'50'	=>	'重庆市',
		'51'	=>	'四川省',
		'52'	=>	'贵州省',
		'53'	=>	'云南省',
		'54'	=>	'西藏自治区',
		'61'	=>	'陕西省',
		'62'	=>	'甘肃省',
		'63'	=>	'青海省',
		'64'	=>	'宁夏回族自治区',
		'65'	=>	'新疆维吾尔族自治区',
		'71'	=>	'台湾省',
		'81'	=>	'香港特别行政区',
		'82'	=>	'澳门特别行政区',
	);
	$id = substr($idcard, 0, 2);
	return array_key_exists($id, $provinces) ? $provinces[$id] : 0;
}
