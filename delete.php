<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('config/database.php');

$id_post = $_POST['id_post'];
$stmt = $dbh->prepare("DELETE FROM `posts` WHERE `id_post` = :id_post;");
$stmt->bindParam(':id_post', $id_post);
$stmt->execute();
$stmt = $dbh->prepare("DELETE FROM `comments` WHERE `fk_id_post`=:id_post;");
$stmt->bindParam(':id_post', $id_post);
$stmt->execute();
$stmt = $dbh->prepare("DELETE FROM `likes` WHERE `fk_id_post`=:id_post;");
$stmt->bindParam(':id_post', $id_post);
$stmt->execute();