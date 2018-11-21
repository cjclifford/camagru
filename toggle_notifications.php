<?php

session_start();
require_once('config/database.php');

$stmt = $dbh->prepare("UPDATE `users` SET `notify` = :notify WHERE `username` = :username;");
$stmt->bindParam(':notify', $_POST['notify']);
$stmt->bindParam(':username', $_SESSION['user']);
$stmt->execute();