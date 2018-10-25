<?php

function is_valid_name($name) {
	if (!$name || $name == "")
		return false;
	$pattern = '/^[A-Za-z\-]{1,16}$/';
	if (!preg_match($pattern, $name))
		return false;
	return true;
	}
	
function is_valid_user($user) {
	if (!$user || $user == "")
		return false;
	$pattern = '/^[A-Za-z0-9]{1,16}$/';
	if (!preg_match($pattern, $user))
		return false;
	return true;
}
		
function is_valid_email($email) {
	if (!$email || $email == "")
		return false;
	$pattern = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
	if (!preg_match($pattern, $email))
		return false;
	return true;
}
			
function is_valid_password($pass) {
	if (!$pass || $pass == "")
		return false;
	$pattern = '/^(?=.*?[0-9])(?=.*?[A-Za-z])(?=.*?[@$!%*#?&]).{8,}$/';
	if (!preg_match($pattern, $pass))
		return false;
	return true;
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

if (!is_valid_name($firstname)) {
	header("Location: index.php");
	return;
}
if (!is_valid_name($lastname)) {
	header("Location: index.php");
	return;
}
if (!is_valid_name($username)) {
	header("Location: index.php");
	return;
}
if (!is_valid_email($email)) {
	header("Location: index.php");
	return;
}
if (!is_valid_password($password)) {
	header("Location: index.php");
	return;
}
if ($password != $cpassword) {
	header("Location: index.php");
	return;
}

require_once('config/database.php');

$query = "INSERT INTO user (firstname, lastname, username, email, password)
		VALUES ('$firstname', '$lastname', '$username', '$email', '" . hash('sha256', $password) . "');";
$stmt = $dbh->prepare($query)->execute();

header("Location: index.php");