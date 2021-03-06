<?php

session_start();
require_once('verify_data.php');

if (usernameExists($_POST['new']))
	echo "error";
else {
	$stmt = $dbh->prepare("UPDATE `users` SET `username` = :newUsername WHERE `username` = :username;");
	$stmt->bindParam(':newUsername', $_POST['new']);
	$stmt->bindParam(':username', $_SESSION['user']);
	$stmt->execute();

	$_SESSION['user'] = $_POST['new'];
}