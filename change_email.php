<?php

session_start();
require_once("config/database.php");
require_once("verify_data.php");

if (emailExists($_POST['new']))
	echo 'error';
else {
	$stmt = $dbh->prepare("UPDATE `users` SET `email` = :email WHERE `username` = :username;");
	$stmt->bindParam(':email', $_POST['new']);
	$stmt->bindParam(':username', $_SESSION['user']);
	$stmt->execute();
}