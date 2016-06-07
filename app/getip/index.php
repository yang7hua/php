#!/usr/local/php5/bin/php
<?php

require './phpmailer.class.php';
require './smtp.class.php';

function get_onlineip() 
{ 
	$socket = socket_create(AF_INET, SOCK_STREAM, 6);  
	$ret = socket_connect($socket,'ns1.dnspod.net',6666);  
	$buf = socket_read($socket, 16);  
	socket_close($socket);  
	return $buf;  
} 

$ip = get_onlineip();

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('', '');
$mail->addAddress('', '');     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Your ip is changed.';
$mail->Body    = 'IP: '.$ip;

if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'Message has been sent';
}
echo "\n";

exit();
