<?php

require_once('config/database.php');

function usernameExists($username) {
	global $dbh;
	$stmt = $dbh->prepare("SELECT COUNT(`username`) FROM `users` WHERE `username` = :username;");
	$stmt->bindParam(':username', $username);
	$stmt->execute();
	return $stmt->fetch()[0] == 0 ? 0 : 1;
}

function emailExists($email) {
	global $dbh;
	$stmt = $dbh->prepare("SELECT COUNT(`email`) FROM `users` WHERE `email` = :email;");
	$stmt->bindParam(':email', $email);
	$stmt->execute();
	return $stmt->fetch()[0] == 0 ? 0 : 1;
}