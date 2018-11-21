<?php

session_start();
require_once('config/database.php');

function getUserData($username) {
	global $dbh;
	$stmt = $dbh->prepare("SELECT * FROM `users` WHERE `username` = :username;");
	$stmt->bindParam(':username', $username);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['request'])) {
	if ($_POST['request'] == 'username') {
		echo getUserData($_SESSION['user'])['username'];
	}

	if ($_POST['request'] == 'email') {
		echo getUserData($_SESSION['user'])['email'];
	}

	if ($_POST['request'] == 'notify') {
		echo (bool) getUserData($_SESSION['user'])['notify'];
	}
}
