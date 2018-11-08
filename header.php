<?php

function load_header() {
	if (isset($_SESSION['user'])) {
?>
		<div class="navbar">
			<img class="image-link" src="resources/icons/camera_icon.png" width="40px" height="40px" onclick='loadDoc("camera")' />
			<img class="circle-image image-link" src="resources/icons/user.png" width="40px" height="40px" />
			<h4 class="username noselect"><?php echo $_SESSION['user']; ?></h4>
			<form action="logout.php"><input type="submit" class="cta-button" name="submit" value="Logout" /></form>
		</div>
<?php
	}
	else {
?>
		<div class="navbar">
			<button class="cta-button" onclick='loadDoc("signup")'>Sign Up</button>
			<button class="cta-button" onclick='loadDoc("login")'>Log In</button>
		</div>
	</form>
<?php
	}
}