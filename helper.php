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