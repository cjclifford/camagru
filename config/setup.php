<?php

require_once('config.php');

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
$stmt = "DROP DATABASE IF EXISTS `$DB_NAME`";
$new_db->exec($stmt);
$stmt = "CREATE DATABASE IF NOT EXISTS `$DB_NAME`";
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
			`password` VARCHAR(255) NOT NULL
		)";
$dbh->exec($stmt);

/*
** Post Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`posts` (
			`id_post` INT PRIMARY KEY AUTO_INCREMENT,
			`image_path` VARCHAR(255),
			`like_count` INT DEFAULT 0,
			`timestamp` DATETIME NOT NULL DEFAULT current_timestamp,
			`fk_id_user` INT REFERENCES `user`(`id_user`)
		)";
$dbh->exec($stmt);

/*
** Comment Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`comments` (
			`comment` TEXT NOT NULL,
			`timestamp` DATETIME NOT NULL DEFAULT current_timestamp,
			`fk_id_user` INT REFERENCES `user`(`id_user`),
			`fk_id_post` INT REFERENCES `user`(`id_post`)
		)";
$dbh->exec($stmt);

/*
** Likes Table
*/
$stmt = "CREATE TABLE IF NOT EXISTS `$DB_NAME`.`likes` (
			`fk_id_user` INT REFERENCES `user`(`id_user`),
			`fk_id_post` INT REFERENCES `user`(`id_post`)
		)";
$dbh->exec($stmt);