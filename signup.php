<?php

session_start();

if (!isset($GLOBALS['firstname'])) {
	echo 'setting firstname global';
	$GLOBALS['firstname'] = $_POST['firstname'];
}
if (!isset($GLOBALS['lastname']))
	$GLOBALS['lastname'] = $_POST['lastname'];
if (!isset($GLOBALS['email']))
	$GLOBALS['email'] = $_POST['email'];
if (!isset($GLOBALS['username']))
	$GLOBALS['username'] = $_POST['username'];
if (!isset($GLOBALS['password']))
	$GLOBALS['password'] = $_POST['password'];
$verified = $_POST['verified'];

require_once('config/database.php');

$stmt = $dbh->prepare("SELECT COUNT(`username`) FROM `users` WHERE `username` = :username;");
$stmt->bindParam(':username', $username);
$stmt->execute();
$username_count = $stmt->fetch()[0];

$stmt = $dbh->prepare("SELECT COUNT(`email`) FROM `users` WHERE `email` = :email;");
$stmt->bindParam(':email', $email);
$stmt->execute();
$email_count = $stmt->fetch()[0];

if ($verified == "true") {
	print_r($GLOBALS);
	$hash = hash('sha256', $password);
	$stmt = $dbh->prepare("INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `password`) VALUES (:firstname, :lastname, :username, :email, :password);");
	$stmt->bindParam(':firstname', $GLOBALS['firstname'], PDO::PARAM_STR);
	$stmt->bindParam(':lastname', $GLOBALS['lastname'], PDO::PARAM_STR);
	$stmt->bindParam(':username', $GLOBALS['username'], PDO::PARAM_STR);
	$stmt->bindParam(':email', $GLOBALS['email'], PDO::PARAM_STR);
	$stmt->bindParam(':password', $hash, PDO::PARAM_STR);
	$stmt->execute();
	$_SESSION['user'] = $GLOBALS['username'];
}

if ($username_count == 0 && $email_count == 0)
	echo '0';
else if ($username_count != 0 && $email_count != 0)
	echo '1';
else if ($username_count != 0)
	echo '2';
else if ($email_count != 0)
	echo '3';