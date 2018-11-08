<?php

session_start();
require_once('config/database.php');

if (isset($_POST['id_post']) && isset($_POST['comment'])) {
	$stmt = $dbh->prepare("SELECT `id_user` FROM `users` WHERE `username` = :username;");
	$stmt->bindParam(':username', $_SESSION['user']);
	$stmt->execute();
	$id_user = $stmt->fetch(PDO::FETCH_ASSOC)['id_user'];

	$stmt = $dbh->prepare("INSERT INTO `comments` (`comment`, `fk_id_user`, `fk_id_post`) VALUES (:comment, :id_user, :id_post);");
	$stmt->bindParam(':comment', $_POST['comment']);
	$stmt->bindParam(':id_user', $id_user);
	$stmt->bindParam(':id_post', $_POST['id_post']);
	$stmt->execute();
}