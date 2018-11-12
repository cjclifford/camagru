<?php

$image = str_replace('data:image/png;base64,', '', $_POST['imageData']);
$image = str_replace(' ', '+', $image);
$image = base64_decode($image);
$image = imagecreatefromstring($image);

session_start();
require_once('config/database.php');

$stmt = $dbh->prepare("SELECT `id_user` FROM `users` WHERE `username` = :user;");
$stmt->bindParam(':user', $_SESSION['user']);
$stmt->execute();
$id_user = $stmt->fetch()['0'];

$stmt = $dbh->prepare("INSERT INTO `posts` (`fk_id_user`)
	VALUES (:fk_id_user);");
$stmt->bindParam(':fk_id_user', $id_user);
$stmt->execute();

$stmt = $dbh->prepare("SELECT MAX(`id_post`) FROM `posts`;");
$stmt->execute();
$id_post = $stmt->fetch()['0'];

$path = "./resources/posts/$id_post.png";
imagepng($image, $path);

$stmt = $dbh->prepare('UPDATE `posts`
	SET `image_path` = :image_path
	WHERE `id_post` = :id_post;');
$stmt->bindParam(':image_path', $path);
$stmt->bindParam(':id_post', $id_post);
$stmt->execute();