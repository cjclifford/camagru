<?php

session_start();
require_once('config/database.php');

$stmt = $dbh->prepare("SELECT * FROM `posts`
	INNER JOIN `users` ON `posts`.`fk_id_user` = `users`.`id_user`;");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT * FROM `comments`
	INNER JOIN `posts` ON `comments`.`fk_id_post` = `posts`.`id_post`
	LEFT JOIN `users` ON `comments`.`fk_id_user` = `users`.`id_user`;");
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT * FROM `likes`
	INNER JOIN `posts` ON `likes`.`fk_id_post` = `posts`.`id_post`
	LEFT JOIN `users` ON `likes`.`fk_id_user` = `users`.`id_user`;");
$stmt->execute();
$likes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = "";

$xml = new DOMDocument();
foreach ($posts as $post) {
	$xml->loadHTML(file_get_contents('post.html'));

	$xml->getElementById('post-image')->setAttribute('src', $post['image_path']);

	$xml->getElementById('profile-picture')->setAttribute('src', 'resources/icons/user.png');

	$xml->getElementById('post')->setAttribute('id', $post['id_post']);

	$element = $xml->getElementById('timestamp');
	$fragment = $xml->createDocumentFragment();
	$fragment->appendXML(date('d F Y', strtotime($post['timestamp'])));
	$element->appendChild($fragment);

	$element = $xml->getElementById('likes');
	$fragment = $xml->createDocumentFragment();
	$fragment->appendXML($post['like_count']." like");
	if ($post['like_count'] != 1)
		$fragment->appendXML("s");
	$element->appendChild($fragment);

	$element = $xml->getElementById('post-comments');
	foreach ($comments as $comment) {
		$fragment = $xml->createDocumentFragment();
		if ($comment['fk_id_post'] == $post['id_post']) {
			$fragment->appendXML("<b>".$comment['username']."</b> ");
			$fragment->appendXML($comment['comment']."<br/>");
			$element->appendChild($fragment);
		}
	}

	$element = $xml->getElementById('user-name');
	$fragment = $xml->createDocumentFragment();
	$fragment->appendXML($post['username']);
	$element->appendChild($fragment);

	foreach($likes as $like) {
		if ($like['fk_id_post'] == $post['id_post'] && $like['username'] == $_SESSION['user'])
			$xml->getElementById('post-like')->setAttribute('src', 'resources/icons/like-enable.png');
	}

	$html .= $xml->saveHTML();
}
echo $html;