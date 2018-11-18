<?php

require_once('config/database.php');

$stmt = $dbh->prepare("SELECT `sticker_path` FROM `stickers`;");
$stmt->execute();
$stickers = $stmt->fetchAll();

for ($i = 0; $i < sizeof($stickers); $i++)
	echo "<img id='".$i."' src='".$stickers[$i]['sticker_path']."' onclick='set_sticker(this)' width='100px' height='100px'>";