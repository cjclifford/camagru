<?php

session_start();

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

require_once('config/database.php');

$stmt = $dbh->prepare("SELECT COUNT(`username`) FROM `users` WHERE `username` = :username;");
$stmt->bindParam(':username', $username);
$stmt->execute();
$count = $stmt->fetch()[0];
if ($count == 0) {
	$hash = hash('sha256', $password);
	$stmt = $dbh->prepare("INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `password`) VALUES (:firstname, :lastname, :username, :email, :password);");
	$stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
	$stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':password', $hash, PDO::PARAM_STR);
	$stmt->execute();
	$_SESSION['user'] = $username;
	echo 'true';
}
else
	echo 'false';