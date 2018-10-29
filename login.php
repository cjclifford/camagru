<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

require_once('config/database.php');

$stmt = $dbh->prepare("SELECT `password` FROM `users` WHERE `username` = :username;");
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$hash = $stmt->fetch(PDO::FETCH_ASSOC)['password'];
if (hash('sha256', $password) == $hash) {
	$_SESSION['user'] = $username;
	echo 'true';
}
else
	echo 'false';