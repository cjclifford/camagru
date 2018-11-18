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

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('sticker-preview').innerHTML = this.responseText;
		}
	}
	xhttp.open("POST", "get_stickers.php", true);
	xhttp.send();

	var fileUpload = document.getElementById('file-upload');
	fileUpload.addEventListener('change', (e) => uploadFile(e.target.files));
}

function uploadFile(files) {
	for (var i = 0; i < files.length; i++) {
		if (files[i].type.match(/^image\//)) {
			var file = files[i];
			break;
		}
	}
	var image = new Image();
	image.onload = function() {
		ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
		canvas.style.transform = 'none';
	}
	image.src = URL.createObjectURL(file);
}

function snapshot() {
	ctx.translate(canvas.width, 0);
	ctx.scale(-1, 1);
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
}

function canvasIsEmpty(canvasElement) {
	var blank = document.createElement('canvas');
	blank.width = canvasElement.width;
	blank.height = canvasElement.height;
	return canvasElement.toDataURL() == blank.toDataURL();
}

function upload() {
	var img = canvas.toDataURL();
	var sticker = document.getElementById('sticker-overlay');
	if (!canvasIsEmpty(canvas)) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200)
				console.log(this.responseText);
		}
		xhttp.open('POST', 'upload.php');
		xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		var params = 'imageData=' + encodeURI(img);
		if (sticker.src.includes('.png'))
			params += '&sticker=' + sticker.src;
		xhttp.send(params);
	}
}

function set_sticker(sticker) {
	var canvas = document.getElementById('sticker-overlay');
	canvas.src = sticker.src;
	canvas.style.display = 'initial';
}