<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

$to = $_POST['to'];
$subject = $_POST['subject'];
$txt = $_POST['txt'];
$headers = "From: Camagru <noreply@camagru.africa>" . "\r\n";

try {
	var_dump(mail($to,$subject,$txt,$headers));
	echo $to.' ';
	echo $subject.' ';
	echo $txt.' ';
	echo $headers.' ';
}
catch(Exception $e) {
	echo "Error sending email: " . $e->getMessage();
}