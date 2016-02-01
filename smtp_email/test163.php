<?php
include "Mail163.php";
$paramArr = [];
$paramArr['host'] = "smtp.163.com";
$paramArr['port'] = 25;
$paramArr['userName'] = "tsunwk@163.com";
$paramArr['password'] = "admin123";

$to = ['tsun424@163.com',"zhouyi424@163.com"];
$subject = "Today is a nice day, kind invitation";
$body = "<h1>hello world</h1><div style='background-color:yellow'><p>下午钓螃蟹去么？</p></div>";

$mail = new Mail163($paramArr);

$mail->send($to,$subject,$body);

?>
