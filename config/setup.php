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
$stmt = "DROP DATABASE $DB_NAME";
$new_db->exec($stmt);
$stmt = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
$new_db->exec($stmt);

require_once('database.php');	

/*
** User Table
*/
$stmt = 'CREATE TABLE IF NOT EXISTS user (
			id_user INT PRIMARY KEY AUTO_INCREMENT,
			firstname VARCHAR(255),
			lastname VARCHAR(255),
			username VARCHAR(255),
			email VARCHAR(255),
			password VARCHAR(255)
		)';
$dbh->exec($stmt);

/*
** Post Table
*/
$stmt = 'CREATE TABLE IF NOT EXISTS post (
			id_post INT PRIMARY KEY AUTO_INCREMENT,
			id_user INT,
			image_path VARCHAR(255),
			likes INT,
			creation_date VARCHAR(255)
		)';
$dbh->exec($stmt);

/*
** Comment Table
*/