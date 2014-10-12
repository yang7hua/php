<?php

$game_file = 'gamedata.js';

$data = file_get_contents($game_file);


preg_match_all('/\{[^\{\}]*\}/', $data, $matches);


$result = array();
foreach($matches[0] as $row){
	preg_match('/"id"\s+:\s+"(\d+)",[^\{\}]+"score"\s+:\s+"([\d:]+)",[^\{\}]+"win"\s+:\s+"(\d+)"/', $row, $match);
	$result[] = array($match[1], $match[2], $match[3]);
}

$key = 'hao.game.pwd';

$CURL_OPTS = array(
	CURLOPT_HEADER	=>	false,
	CURLOPT_RETURNTRANSFER	=> true,
	CURLOPT_POST	=>	1,
	CURLOPT_SSL_VERIFYHOST	=>	0,
	CURLOPT_SSL_VERIFYPEER	=>	false,
	CURLOPT_REFERER	=>	'https://www.yiqihao.com'	
);

function execCurl($options)
{
	static $n = 1;
	$ch = curl_init('https://www.yiqihao.com/events/worldcupresult');
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	write($result);
	echo "$n<br/>";
	$n++;
}
function write($data)
{
	$f = fopen('log.txt', 'a');
	fwrite($f, $data);
	fclose($f);
}

$f = fopen('log.txt', 'w');
fclose($f);

$result = [array('id'=>10, 'score'=>'3:0', 'win'=>8)];

foreach($result as $row){
	$CURL_OPTS[CURLOPT_POSTFIELDS]	=	array(
			'id'	=>	$row[0],	
			'score'	=>	$row[1],	
			'win'	=>	$row[2],	
			'key'	=>	$key,
			'do'	=>	'search',
			'type'	=>	'both'
		);	
	execCurl($CURL_OPTS);
}
