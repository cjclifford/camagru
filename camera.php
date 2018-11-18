<?php

session_start();

require_once('header.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css?"<?php echo time(); ?> />
	<script src="auth.js"></script>
</head>
<body onload="init()">
	<div id="container">
		<div id="header">
			<div id="header-container">
				<div id="header-name" class="noselect" onclick='document.location.href="./"'>Camagru</div>
				<?php load_header(); ?>
			</div>
		</div>
		<div id="content">
			<div id="editor-container" class="content-box">
				<div id="sticker-preview"></div>
				<div id="preview-wrapper">
					<video id="webcam" autoplay="true"></video>
					<img id="sticker-overlay" src="">
				</div>
				<button id="capture-button" onclick="snapshot()"></button>
				<button class="cta-button" onclick="upload()">Upload</button>
				<input id="file-upload" type="file" accepts="image/*" />
				<canvas id="snapshot" width="640" height="480"></canvas>
				<script src="camera.js"></script>
			</div>
		</div>
		<div id="footer">© Cuan Clifford</div>
	</div>
</body>
</html>

