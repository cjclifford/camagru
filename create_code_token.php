<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('config/database.php');
require_once('get_user_data.php');

$stmt = $dbh->prepare("INSERT INTO `tokens` (`token`, `username`) VALUES (:token, :username);");
$stmt->bindParam(':token', $_POST['token']);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();