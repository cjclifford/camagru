<?php

session_start();

$oldPassword = $_POST['old'];
$newPassword = $_POST['new'];
$confirmPassword = $_POST['confirm'];

require_once('config/database.php');

$stmt = $dbh->prepare("SELECT `password` FROM `users` WHERE `username` = :username;");
$stmt->bindParam(':username', $_SESSION['user']);
$stmt->execute();
$hash = $stmt->fetch()[0];

if (hash('sha256', $oldPassword) == strtolower($hash)) {
	if ($newPassword == $confirmPassword) {
		$newHash = hash('sha256', $newPassword);
		$stmt = $dbh->prepare("UPDATE `users` SET `password` = :hash WHERE `username` = :username;");
		$stmt->bindParam(':hash', $newHash);
		$stmt->bindParam(':username', $_SESSION['user']);
		$stmt->execute();
		echo 'success';
	}
	else
		echo 'Passwords do not match';
}
else
	echo 'Incorrect password';