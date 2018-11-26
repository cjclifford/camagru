<?php

session_start();

require_once('header.php');

if (!isset($_GET['page']))
	$_SESSION['page'] = 1;
else
	$_SESSION['page'] = $_GET['page'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css?"<?php echo time(); ?> />
	<link rel="shortcut icon" type="image/png" href="resources/icons/camera_icon.png"/>
	<script src="load_content.js"></script>
	<script src="auth.js"></script>
	<script src="post_action.js"></script>
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="header-container">
				<div id="header-name" class="noselect" onclick="window.location = 'index.php'">Camagru</div>
				<?php load_header(''); ?>
			</div>
		</div>
		<div id="content"></div>
		<script>loadDoc();</script>
		<div id="footer">© Cuan Clifford</div>
	</div>
</body>
</html>