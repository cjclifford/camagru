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
	<script src="load_content.js"></script>
	<script src="auth.js"></script>
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="header-container">
				<div id="header-name" class="noselect" onclick="location.reload()">Camagru</div>
				<?php load_header(); ?>
			</div>
		</div>
		<div id="content" onload="loadDoc()"></div>
		<div id="footer"></div>
	</div>
</body>
</html>