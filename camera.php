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
	<link rel="shortcut icon" type="image/png" href="resources/icons/camera_icon.png"/>
	<script src="auth.js"></script>
	<script src="load_content.js"></script>
</head>
<body onload="init()">
	<div id="container">
		<div id="header">
			<div id="header-container">
				<div id="header-name" class="noselect" onclick="window.location='index.php'">Camagru</div>
				<?php load_header('camera'); ?>
			</div>
		</div>
		<div id="content">
			<div id="editor-container" class="content-box">
				<div id="sticker-preview"></div>
				<div id="preview-wrapper">
					<video id="webcam" autoplay="true"></video>
					<canvas id="snapshot" width="640px" height="480px"></canvas>
				</div>
				<div id="editor-options-1">
					<button id="capture-button" onclick="snapshot()"></button>
					<button id="reset-preview-button" class="cta-button" onclick="resetPreview()">Reset</button>
				</div>
				<div id="editor-options-2">
					<button class="cta-button" onclick="upload()">Upload</button>
					<input id="file-upload" type="file" accepts="image/*" onclick="snapshot()" />
				</div>
				<script src="camera.js"></script>
			</div>
		</div>
		<div id="footer">© Cuan Clifford</div>
	</div>
</body>
</html>

