<?php

require_once('config.php');
foreach (glob('../resources/posts/*') as $path)
	unlink($path);

/*
** Connect to host
*/
try {
	$new_db = new PDO('mysql:host='.$DB_HOST, $DB_USER, $DB_PASSWORD);
	$new_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

/*
** Create or recreate database
*/
$stmt = "DROP DATABASE IF EXISTS `$DB_NAME`;";
$new_db->exec($stmt);
$stmt = "CREATE DATABASE IF NOT EXISTS `$DB_NAME`;";
$new_db->exec($stmt);

require_once('database.php');	

/*
** User Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`users` (
	`id_user` INT PRIMARY KEY AUTO_INCREMENT,
	`firstname` VARCHAR(255) NOT NULL,
	`lastname` VARCHAR(255) NOT NULL,
	`username` VARCHAR(255) NOT NULL UNIQUE,
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`notify` INT NOT NULL DEFAULT 1
);";
$dbh->exec($stmt);

/*
** Post Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`posts` (
	`id_post` INT PRIMARY KEY AUTO_INCREMENT,
	`image_path` VARCHAR(255),
	`like_count` INT DEFAULT 0,
	`timestamp` DATETIME NOT NULL DEFAULT current_timestamp,
	`fk_id_user` INT REFERENCES `users`(`id_user`)
);";
$dbh->exec($stmt);

/*
** Comment Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`comments` (
	`comment` TEXT NOT NULL,
	`timestamp` DATETIME NOT NULL DEFAULT current_timestamp,
	`fk_id_user` INT REFERENCES `users`(`id_user`),
	`fk_id_post` INT REFERENCES `users`(`id_post`)
);";
$dbh->exec($stmt);

/*
** Likes Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`likes` (
	`fk_id_user` INT REFERENCES `users`(`id_user`),
	`fk_id_post` INT REFERENCES `users`(`id_post`)
);";
$dbh->exec($stmt);

/*
** Stickers Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`stickers` (
	`id_sticker` INT PRIMARY KEY AUTO_INCREMENT,
	`sticker_path` VARCHAR(255)
);";
$dbh->exec($stmt);

/*
** Token Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`tokens` (
	`token` VARCHAR(6) NOT NULL,
	`username` VARCHAR(255)
);";
$dbh->exec($stmt);

// make some test users
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`users` (`firstname`, `lastname`, `username`, `email`, `password`) VALUES ('mickey', 'mouse', 'mmouse', 'mmouse@clubhouse.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855');");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`users` (`firstname`, `lastname`, `username`, `email`, `password`) VALUES ('willem', 'dafoe', 'wdafoe', 'wdafoe@gmail.com', '5E884898DA28047151D0E56F8DC6292773603D0D6AABBDD62A11EF721D1542D8');");
$stmt->execute();

// make some stickers
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`stickers` (`sticker_path`) VALUES ('resources/stickers/overlay_crown.png');");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`stickers` (`sticker_path`) VALUES ('resources/stickers/overlay_cutie.png');");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`stickers` (`sticker_path`) VALUES ('resources/stickers/overlay_fu.png');");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`stickers` (`sticker_path`) VALUES ('resources/stickers/overlay_idc.png');");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`stickers` (`sticker_path`) VALUES ('resources/stickers/overlay_wow.png');");
$stmt->execute();

// make some tests posts
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`posts` (`image_path`, `fk_id_user`) VALUES ('resources/test/test-post-1.jpeg', 1);");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`posts` (`image_path`, `fk_id_user`) VALUES ('resources/test/test-post-2.jpeg', 2);");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`posts` (`image_path`, `fk_id_user`) VALUES ('resources/test/test-post-3.jpeg', 2);");
$stmt->execute();
$stmt = $dbh->prepare("INSERT INTO `$DB_NAME`.`posts` (`image_path`, `fk_id_user`) VALUES ('resources/test/test-post-4.jpg', 1);");
$stmt->execute();

session_start();
$_SESSION['user'] = 'mmouse';