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