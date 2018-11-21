<?php

session_start();
require_once('config/database.php');

if ($_SESSION['user']) {
	if (isset($_POST['id_post'])) {
		$stmt = $dbh->prepare("SELECT `id_user` FROM `users` WHERE `username` = :username;");
		$stmt->bindParam(':username', $_SESSION['user']);
		$stmt->execute();
		$id_user = $stmt->fetch(PDO::FETCH_ASSOC)['id_user'];

		$stmt = $dbh->prepare("SELECT COUNT(*) FROM `likes` WHERE `fk_id_user` = :id_user AND `fk_id_post` = :id_post;");
		$stmt->bindParam(':id_user', $id_user);
		$stmt->bindParam(':id_post', $_POST['id_post']);
		$stmt->execute();
		if ($stmt->fetch()[0] == 0) {
			$stmt = $dbh->prepare("INSERT INTO `likes` (`fk_id_user`, `fk_id_post`) VALUES (:id_user, :id_post);");
			$stmt->bindParam(':id_user', $id_user);
			$stmt->bindParam(':id_post', $_POST['id_post']);
			$stmt->execute();

			$stmt = $dbh->prepare("UPDATE `posts` SET `like_count` = `like_count` + 1 WHERE `id_post` = :id_post;");
			$stmt->bindParam(':id_post', $_POST['id_post']);
			$stmt->execute();
		}
		else {
			$stmt = $dbh->prepare("DELETE FROM `likes` WHERE `fk_id_user` = :id_user AND `fk_id_post` = :id_post;");
			$stmt->bindParam(':id_user', $id_user);
			$stmt->bindParam(':id_post', $_POST['id_post']);
			$stmt->execute();

			$stmt = $dbh->prepare("UPDATE `posts` SET `like_count` = `like_count` - 1 WHERE `id_post` = :id_post;");
			$stmt->bindParam(':id_post', $_POST['id_post']);
			$stmt->execute();
		}
	}
}
else
	echo 'false';