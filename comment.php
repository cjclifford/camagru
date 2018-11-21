<?php

session_start();
require_once('config/database.php');

if (isset($_SESSION['user']) && isset($_POST['id_post']) && isset($_POST['comment'])) {
	$stmt = $dbh->prepare("SELECT `id_user` FROM `users` WHERE `username` = :username;");
	$stmt->bindParam(':username', $_SESSION['user']);
	$stmt->execute();
	$id_user = $stmt->fetch(PDO::FETCH_ASSOC)['id_user'];

	$stmt = $dbh->prepare("SELECT `fk_id_user` FROM `posts` WHERE `id_post` = :id_post;");
	$stmt->bindParam(':id_post', $_POST['id_post']);
	$stmt->execute();
	$fk_id_user = $stmt->fetch()[0];

	$stmt = $dbh->prepare("SELECT `username` FROM `users` WHERE `id_user` = :id_user;");
	$stmt->bindParam(':id_user', $fk_id_user);
	$stmt->execute();
	$username = $stmt->fetch()[0];

	if ($username != $_SESSION['user']) {
		$stmt = $dbh->prepare("SELECT `notify` FROM `users` WHERE `id_user` = :id_user;");
		$stmt->bindParam(':id_user', $fk_id_user);
		$stmt->execute();
		$notify = $stmt->fetch()[0];

		if ($notify == 1) {
			$stmt = $dbh->prepare("SELECT email FROM users WHERE id_user = (SELECT fk_id_user FROM posts WHERE id_post = ".$_POST['id_post'].");");
			$stmt->execute();
			$to = $stmt->fetch()[0];
			$subject = 'Someone just commented on your post';
			$txt = $_SESSION['user'] . " just commented on your post.";
			$headers = "From: Camagru" . "\r\n";

			try {
				mail($to,$subject,$txt,$headers);
			}
			catch(Exception $e) {
				echo "Error sending email: " . $e->getMessage();
			}
		}
	}

	$stmt = $dbh->prepare("INSERT INTO `comments` (`comment`, `fk_id_user`, `fk_id_post`) VALUES (:comment, :id_user, :id_post);");
	$stmt->bindParam(':comment', $_POST['comment']);
	$stmt->bindParam(':id_user', $id_user);
	$stmt->bindParam(':id_post', $_POST['id_post']);
	$stmt->execute();
}
if (!isset($_SESSION['user']))
	echo 'false';