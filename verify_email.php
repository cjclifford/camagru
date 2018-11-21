<?php

session_start();
require_once('config/database.php');
require_once('get_user_data.php');

$stmt = $dbh->prepare("SELECT `token` FROM `tokens` WHERE `username` = :username;");
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$db_token = $stmt->fetch()[0];

if ($db_token == $_GET['token']) {
	$stmt = $dbh->prepare("DELETE FROM `tokens` WHERE `token` = :token;");
	$stmt->bindParam(':token', $_GET['token']);
	$stmt->execute();

	$hash = hash('sha256', $_SESSION['password']);
	$stmt = $dbh->prepare("INSERT INTO `users`
		(`firstname`, `lastname`, `username`, `email`, `password`)
		VALUES (:firstname, :lastname, :username, :email, :password);");
	$stmt->bindParam(':firstname', $_SESSION['firstname'], PDO::PARAM_STR);
	$stmt->bindParam(':lastname', $_SESSION['lastname'], PDO::PARAM_STR);
	$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
	$stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
	$stmt->bindParam(':password', $hash, PDO::PARAM_STR);
	$stmt->execute();
	
	$_SESSION['user'] = $_SESSION['username'];
	
	unset($_SESSION['firstname']);
	unset($_SESSION['lastname']);
	unset($_SESSION['username']);
	unset($_SESSION['email']);
	unset($_SESSION['password']);
	unset($_GET['token']);

	header("Location: index.php");
}
else
	echo "Error: Invalid token.";