<?php

session_start();
require_once('config/database.php');

$stmt = $dbh->prepare("SELECT * FROM `posts`
	INNER JOIN `users` ON `posts`.`fk_id_user` = `users`.`id_user`
	ORDER BY `timestamp` DESC
	LIMIT :page,5;");
$page = (int)(($_SESSION['page'] - 1) * 5);
$stmt->bindParam(':page', $page, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

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
	if ($post['username'] == $_SESSION['user']) {
		$element = $xml->getElementById('delete');
		$element->setAttribute('src', 'resources/icons/delete.png');
		$element->setAttribute('onclick', 'deletePost(this)');
		$element->setAttribute('style', 'display:initial');
	}

	$element = $xml->getElementById('likes');
	$fragment = $xml->createDocumentFragment();
	$fragment->appendXML($post['like_count']." like");
	if ($post['like_count'] != 1)
		$fragment->appendXML('s');
	$element->appendChild($fragment);

	$element = $xml->getElementById('post-comments');
	foreach ($comments as $comment) {
		$fragment = $xml->createDocumentFragment();
		if ($comment['fk_id_post'] == $post['id_post']) {
			$fragment->appendXML("<b>".$comment['username']."</b> ");
			$fragment->appendXML(htmlspecialchars($comment['comment'])."<br/>");
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
$xml = new DOMDocument();
$stmt = $dbh->prepare("SELECT COUNT(*) FROM `posts`;");
$stmt->execute();
$postCount = $stmt->fetch()[0];
$pageCount = ceil($postCount / 5);

for ($i = 1; $i <= $pageCount; $i++) {
	$element = $xml->createElement('a');
	$element->setAttribute('href', 'http://localhost:8080/www/camagru/index.php?page='.$i);
	$div = $xml->createElement('div', $i);
	$div->setAttribute('class', 'content-box page-link');
	$element->appendChild($div);
	$xml->appendChild($element);
}
$html .= $xml->saveHTML();

echo $html;