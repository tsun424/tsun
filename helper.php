<?php

function convertCamelKey(&$array)
{
    foreach (array_keys($array) as $key){
        $value = &$array[$key];
        unset($array[$key]);
        $transformedKey = camelCase($key);
        if (is_array($value)) {
            convertCamelKey($value);
        }
        $array[$transformedKey] = $value;      
        unset($value);
    }
}

function camelCase($str){
    return  lcfirst(str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $str))));
}

$testArr = [
	0 => [ 'test_name' => [
							0 => 'abc', 
							1 => 'def'
						  ],
			'test_name2' => "test_name2"],
];

convertCamelKey($testArr);
var_dump($testArr);


function countSeason($endTime = "now"){
	$returnArr = [];
	$timeUnix = strtotime($endTime);
	$season = ceil(date('n', $timeUnix)/3);
	$firstTimeUnix = mktime(0, 0, 0,$season*3-2,1,date('Y', strtotime("-2 year", $timeUnix)));
	$endDateUnix = mktime(23, 59, 59,$season*3,1,date('Y', $timeUnix));
	$nextMonthUnix = $firstTimeUnix;
	while ($nextMonthUnix < $endDateUnix) {
		$tempStart = date('Y-m-01', $nextMonthUnix);
		$tempEnd = date('Y-m-t', strtotime("+2 month", $nextMonthUnix));
		$key = $tempStart."~".$tempEnd;
		$value = date('M Y', $nextMonthUnix)."~".date('M Y', strtotime("+2 month", $nextMonthUnix));
		$returnArr[$key] = $value;
		$nextMonthUnix = strtotime("+3 month", $nextMonthUnix);
	}
	return $returnArr;
}
var_dump(countSeason("2016-11-01"));