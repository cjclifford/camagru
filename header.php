<?php

session_start();

function load_header() {
	if ($_SESSION['user']) {
?>
		<img class="profile-image" src="" width="40px" height="40px" />
		User
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