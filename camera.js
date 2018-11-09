var video = document.querySelector('#webcam');

if (navigator.mediaDevices.getUserMedia) {
	navigator.mediaDevices.getUserMedia({ video: true })
	.then(function (stream)	{
		video.srcObject = stream;
	})
	.catch(function() {
		console.log("Error: Could not load webcam.");
	});
}

var canvas, ctx;

function init() {
	canvas = document.getElementById("snapshot");
	ctx = canvas.getContext('2d');
}

function snapshot() {
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
}

function upload() {
	var img = canvas.toDataURL();
	// var link = document.createElement('a');
	// link.setAttribute('href', img);
	// link.click();
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			console.log(this.responseText);
	}
	xhttp.open('POST', 'upload.php');
	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhttp.send('imageData=' + escape(img));
}