<?php

$to = $_POST['to'];
$subject = $_POST['subject'];
$txt = $_POST['txt'];
$headers = "From: Camagru" . "\r\n";

try {
	mail($to,$subject,$txt,$headers);
}
catch(Exception $e) {
	echo "Error sending email: " . $e->getMessage();
}