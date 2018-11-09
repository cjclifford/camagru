<?php

$image = str_replace('data:image/png;base64,', '', $_POST['imageData']);
$image = str_replace(' ', '+', $image);
$image = base64_decode($image);
$image = imagecreatefromstring($image);
imagepng($image, './resources/posts/test.png');

session_start();
require_once('config/database.php');

$stmt = $dbh->prepare('SELECT `id_user` FROM `users` WHERE `username` = $_SESSION['user'];');
$stmt->execute();
$id_user = $stmt
// $stmt = $dbh->prepare('INSERT INTO posts');