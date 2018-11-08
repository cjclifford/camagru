function loadDoc(file) {
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			document.getElementById('content').innerHTML = this.responseText;
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
		else
			xhttp.open("GET", "gallery.php", true);
		xhttp.send();
	}
}
loadDoc();