<?php

function load_header() {
	if (isset($_SESSION['user'])) {
?>
		<div class="navbar">
			<img class="image-link" src="resources/images/camera_icon.png" width="40px" height="40px" onclick='loadDoc("camera")' />
			<img class="circle-image image-link" src="resources/images/test-profile-picture.png" width="40px" height="40px" />
			<h4 class="noselect">User</h4>
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