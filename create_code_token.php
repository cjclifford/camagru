<?php

require_once('config/database.php');
require_once('get_user_data.php');

$stmt = $dbh->prepare("INSERT INTO `tokens` (`token`, `username`) VALUES (:token, :username);");
$stmt->bindParam(':token', $_POST['token']);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();