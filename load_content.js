function loadDoc(file) {
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
			document.getElementById('content').innerHTML = this.responseText;
			if (file == "settings") {
				getUsername();
				getEmail();
				getNotify();
			}
		}
		if (this.readyState == 4 && this.status == 404)
			document.getElementById('body').innerHTML = "Error: Not Found.";
	};
	if (file == "camera") {
		document.location.href = "camera.php";
	}
	else {
		if (file == "signup")
			xhttp.open("GET", "get_file.php?page=sign_up.html", true);
		else if (file == "login")
			xhttp.open("GET", "get_file.php?page=log_in.html", true);
		else if (file == "settings")
			xhttp.open("GET", "get_file.php?page=settings.html", true);
		else
			xhttp.open("GET", "gallery.php", true);
		xhttp.send();
	}
}

function getUsername() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			document.getElementById('username').value = this.responseText;
	}
	xhttp.open("POST", "get_user_data.php");
	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhttp.send('request=username');
}

function getEmail() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			document.getElementById('email').value = this.responseText;
	}
	xhttp.open("POST", "get_user_data.php");
	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhttp.send('request=email');
}

function getNotify() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			document.getElementById('notify').checked = this.responseText;
	}
	xhttp.open("POST", "get_user_data.php");
	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhttp.send('request=notify');
}