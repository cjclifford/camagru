function is_valid_user(user) {
	if (!user || user == "")
		return false;
	var pattern = /^[A-Za-z0-9]{1,16}$/;
	if (!pattern.test(user))
		return false;
	return true;
}

function is_valid_password(password) {
	if (!password || password == "")
		return false;
	var pattern = /^(?=.*?[0-9])(?=.*?[A-Za-z])(?=.*?[@$!%*#?&]).{8,}$/;
	if (!pattern.test(password))
		return false;
	return true;
}

function is_valid_email(email) {
	if (!email || email == "")
		return false;
		var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (!pattern.test(email))
		return false;
	return true;
}

function is_valid_name(name) {
	if (!name || name == "")
		return false;
	var pattern = /^[A-Za-z\-]{1,16}$/;
	if (!pattern.test(name))
		return false;
	return true;
}

function validate_signup() {
	var valid = true;

	var firstname = document.getElementById('register-firstname').value;
	var lastname = document.getElementById('register-lastname').value;
	var email = document.getElementById('register-email').value;
	var username = document.getElementById('register-username').value;
	var password = document.getElementById('register-password').value;
	var cpassword = document.getElementById('register-cpassword').value;

	document.getElementById('rsp-firstname').style.display = 'none';
	document.getElementById('rsp-lastname').style.display = 'none';
	document.getElementById('rsp-username').style.display = 'none';
	document.getElementById('rsp-email').style.display = 'none';
	document.getElementById('rsp-password').style.display = 'none';
	document.getElementById('rsp-cpassword').style.display = 'none';

	if (!is_valid_name(firstname)) {
		document.getElementById('rsp-firstname').style.display = 'block';
		valid = false;
	}
	if (!is_valid_name(lastname)) {
		document.getElementById('rsp-lastname').style.display = 'block';
		valid = false;
	}
	if (!is_valid_user(username)) {
		document.getElementById('rsp-username').style.display = 'block';
		valid = false;
	}
	if (!is_valid_email(email)) {
		document.getElementById('rsp-email').style.display = 'block';
		valid = false;
	}
	if (!is_valid_password(password)) {
		document.getElementById('rsp-password').style.display = 'block';
		valid = false;
	}
	if (password != cpassword) {
		document.getElementById('rsp-cpassword').style.display = 'block';
		valid = false;
	}

	if (valid) {
		var superValid = null;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (!superValid)
					superValid = this.responseText;
				console.log('inside ' + superValid);
			}
		};
		xhttp.open("POST", "auth.php", true);
		// xhttp.send();
		var params = 'firstname=' + firstname + '&' + 'lastname=' + lastname + '&' + 'username=' + username + '&' + 'email=' + email + '&' + 'password=' + password;
		xhttp.send(params);
		// console.log("firstname=" + firstname + "&" + "lastname=" + lastname + "&" + "username=" + username + "&" + "email=" + email + "&" + "password=" + password);
	}
}

function validate_login() {
	var username = document.getElementById('register-username');
	var password = document.getElementById('register-password');

	document.getElementById('rsp-login').style.display = 'block';
}