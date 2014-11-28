<?php

$content = file_get_contents('log.txt');


preg_match_all('/\{[^\{\}]*\}/', $content, $matches);

$result = array();
$point = 0;

foreach($matches[0] as $match){
	preg_match('/"uid":"(\d+)".*"point":(\d+)/', $match, $datas);
	if(array_key_exists(@$datas[1], $result)){
		@$result[$datas[1]] += $datas[2];
	}else{
		@$result[$datas[1]]  = $datas[2];
	}
	@$point += $datas[2];
}

echo count($result) . "<br/>";
echo $point . "<br>";
print_r($result);
/*$f = fopen('result.txt', 'w');
fwrite($f, serialize($result));
fclose($f);
 */
