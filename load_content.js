function loadDoc(file) {
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			document.getElementById('content').innerHTML = this.responseText;
		if (this.readyState == 4 && this.status == 404)
			document.getElementById('body').innerHTML = "Error: Not Found.";
	};
	if (file == "signup")
		xhttp.open("GET", "get_file.php?page=sign_up.html", true);
	else if (file == "login")
		xhttp.open("GET", "get_file.php?page=log_in.html", true);
	else if (file == "camera") {
		xhttp.open("GET", "get_file.php?page=camera.html", true);
		var video = document.querySelector('#webcam');

		if (navigator.mediaDevices.getUserMedia) {
			navigator.mediaDevices.getUserMedia({ video: true })
			.then(function (stream)	{
				video.srcObject = stream;
			})
			.catch(function(err0r) {
				console.log("Error: Could not load webcam.");
			});
		}
	}
	else
		xhttp.open("GET", "gallery.php?filter=recent", true);
	xhttp.send();
	return;
}
loadDoc();