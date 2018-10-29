<?php

require_once('config/database.php');

$stmt = $dbh->prepare("SELECT COUNT(*) FROM `posts`");
$stmt->execute();
$count = $stmt->fetch()[0];

$stmt = $dbh->prepare("SELECT * FROM `posts`;");
$stmt->execute();
$posts = $stmt->fetchAll();

$xml = new DOMDocument();
$xml->loadHTML(file_get_contents('post.html'));
print_r($posts);