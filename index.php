<?php

session_start();

if (!isset($_SESSION['page-content']))
	$_SESSION['page-content'] = 'gallery.html';

function load_header() {
	if ($_SESSION['user']) {
?>
		<ul class="navbar">
			<img class="profile-image" src="resources/images/test-profile-picture.png" width="40px" height="40px" />
			User
			<form action="logout.php"><input type="submit" class="cta-button" name="submit" value="Logout" /></form>
		</ul>
<?php
	}
	else {
?>
		<ul class="navbar">
			<button class="cta-button" onclick='loadDoc("signup")'>Sign Up</button>
			<button class="cta-button" onclick='loadDoc("login")'>Log In</button>
		</ul>
	</form>
<?php
	}
}

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
				<div id="header-name" onclick="loadDoc()">Camagru</div>
				<?php load_header(); ?>
			</div>
		</div>
		<div id="content" onload="loadDoc()"></div>
		<div id="footer">
		</div>
	</div>
</body>
</html>