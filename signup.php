<?php

session_start();
require_once('verify_data.php');

if (isset($_POST['store'])) {
	$_SESSION['firstname'] = $_POST['firstname'];
	$_SESSION['lastname'] = $_POST['lastname'];
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['password'] = $_POST['password'];
}

if (isset($_POST['verified']))
	$verified = $_POST['verified'];

require_once('config/database.php');

if (isset($verified)) {
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
}

$username_count = usernameExists($_SESSION['username']);
$email_count = emailExists($_SESSION['email']);

if ($username_count == 0 && $email_count == 0)
	echo '0';
else if ($username_count != 0 && $email_count != 0)
	echo '1';
else if ($username_count != 0)
	echo '2';
else if ($email_count != 0)
	echo '3';