function isValidUser(user) {
	if (!user || user == "")
		return false;
	var pattern = /^[A-Za-z0-9]{1,16}$/;
	if (!pattern.test(user))
		return false;
	return true;
}

function isValidPassword(password) {
	if (!password || password == "")
		return false;
	var pattern = /^(?=.*?[0-9])(?=.*?[A-Za-z])(?=.*?[@$!%*#?&]).{8,}$/;
	if (!pattern.test(password))
		return false;
	return true;
}

function isValidEmail(email) {
	if (!email || email == "")
		return false;
		var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (!pattern.test(email))
		return false;
	return true;
}

function isValidName(name) {
	if (!name || name == "")
		return false;
	var pattern = /^[A-Za-z\-]{1,16}$/;
	if (!pattern.test(name))
		return false;
	return true;
}

function validateSignup() {
	var valid = true;

	var firstname = document.getElementById('register-firstname').value;
	var lastname = document.getElementById('register-lastname').value;
	var username = document.getElementById('register-username').value;
	var email = document.getElementById('register-email').value;
	var password = document.getElementById('register-password').value;
	var cpassword = document.getElementById('register-cpassword').value;

	var errors = document.getElementsByClassName('rsp');
	for (var i = 0; i < errors.length; i++)
		errors[i].innerHTML = "";

	if (!isValidName(firstname)) {
		document.getElementById('rsp-firstname').innerHTML = "First name cannot contain more than 16 characters and cannot contain special characters.";
		valid = false;
	}
	if (!isValidName(lastname)) {
		document.getElementById('rsp-lastname').innerHTML = "Last name cannot contain more than 16 characters and cannot contain special characters.";
		valid = false;
	}
	if (!isValidUser(username)) {
		document.getElementById('rsp-username').innerHTML = "Username must be unique, cannot contain more than 16 characters, must contain alpha-numeric characters, and cannot be prepended by spaces, hyphens or underscore characters";
		valid = false;
	}
	if (!isValidEmail(email)) {
		document.getElementById('rsp-email').innerHTML = "Invalid email";
		valid = false;
	}
	if (!isValidPassword(password)) {
		document.getElementById('rsp-password').innerHTML = "Password must be at least 8 characters with at least one letter, one number and one special character [@$!%*#?&]";
		valid = false;
	}
	if (password != cpassword) {
		document.getElementById('rsp-cpassword').innerHTML = "Passwords don't match";
		valid = false;
	}

	if (valid) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				if (response == "1" || response == "2") {
					document.getElementById('rsp-username').innerHTML = "Username taken";
				}
				if (response == "1" || response == "3") {
					document.getElementById('rsp-email').innerHTML = "Email already in use";
				}
				if (response == "0") {
					sendVerificationEmail(email);
					loadDoc('verify');
				}
			}
		};
		xhttp.open("POST", "signup.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var params = 'firstname=' + firstname + '&lastname=' + lastname + '&username=' + username + '&email=' + email + '&password=' + password + '&store=true';
		xhttp.send(params);
	}
}

function sendVerificationEmail(email) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText != null)
				console.log(this.responseText);
		}
	}
	xhttp.open("POST", "mail.php", true);
	var code = Math.random().toString(36).toUpperCase().substr(2,6);

	var expireDate = new Date();
	expireDate.setMinutes(expireDate.getMinutes + 1);

	document.cookie = "code="+code+";expires="+expireDate.toUTCString+";";
	var params = 'to=' + email + '&subject=Verification Code&txt=' + code;
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(params);
}

function validateUser() {
	var cookies = document.cookie;
	var cookieCode = cookies.split(';')[0].split('=')[1];
	var code = document.getElementById('verification').value;
	if (code == cookieCode) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText != null)
					console.log(this.responseText);
				location.reload();
			}
		}
		xhttp.open("POST", "signup.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("verified=true");
	}
	else
		document.getElementById('rsp-code').innerHTML = "Incorrect verification code";
}

function validateLogin() {
	var username = document.getElementById('login-username').value;
	var password = document.getElementById('login-password').value;


	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == 'false')
				document.getElementById('rsp-login').innerHTML = "Invalid login credentials"
			else
				location.reload();
		}
	};
	xhttp.open("POST", "login.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var params = 'username=' + username + '&password=' + password;
	xhttp.send(params);
}

function changeUsername() {
	var newUsername = document.getElementById('username').value;

	if (!isValidUser(newUsername))
		document.getElementById('rsp-username').innerHTML = "Username must be unique, cannot contain more than 16 characters, must contain alpha-numeric characters, and cannot be prepended by spaces, hyphens or underscore characters";
	else {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200)
				;//location.reload();
			else
				document.getElementById('rsp-username').innerHTML = this.responseText;
		}
		xhttp.open("POST", "change_username.php");
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhttp.send("new="+newUsername);
	}
}

function changeEmail() {
	var newEmail = document.getElementById('email').value;

	if (!isValidEmail(newEmail))
		document.getElementById('rsp-email').innerHTML = "Username must be unique, cannot contain more than 16 characters, must contain alpha-numeric characters, and cannot be prepended by spaces, hyphens or underscore characters";
	else {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200)
				;// location.reload();
			else
				document.getElementById('rsp-email').innerHTML = this.responseText;
		}
		xhttp.open("POST", "change_email.php");
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhttp.send("new="+newEmail);
	}
}

function changePassword() {
	var oldPassword = document.getElementById('old-password').value;
	var newPassword = document.getElementById('new-password').value;
	var confirmPassword = document.getElementById('confirm-password').value;

	if (!isValidPassword(newPassword))
		document.getElementById('rsp-new-password').innerHTML = "Password must be at least 8 characters with at least one letter, one number and one special character [@$!%*#?&]";
	else if (newPassword != confirmPassword)
		document.getElementById('rsp-confirm-password').innerHTML = "Passwords do not match";
	else {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "success") {
					document.getElementById('old-password').value = "";
					document.getElementById('new-password').value = "";
					document.getElementById('confirm-password').value = "";
				}
				else
					document.getElementById('rsp-old-password').innerHTML = this.responseText;
			}
		}
		xhttp.open("POST", "change_password.php");
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("old="+oldPassword+"&new="+newPassword+"&confirm="+confirmPassword);
	}
}

function toggleNotifications() {
	//
}