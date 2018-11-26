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

	
	ctx.translate(canvas.width, 0);
	ctx.scale(-1, 1);

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
			document.getElementById('sticker-preview').innerHTML = this.responseText;
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
	document.getElementById('snapshot').style.display = 'initial';
	document.getElementById('webcam').style.display = 'none';
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
}

function resetPreview() {
	document.getElementById('snapshot').style.display = 'none';
	document.getElementById('webcam').style.display = 'initial';
	addSticker();
}

function canvasIsEmpty(canvasElement) {
	var blank = document.createElement('canvas');
	blank.width = canvasElement.width;
	blank.height = canvasElement.height;
	return canvasElement.toDataURL() == blank.toDataURL();
}

function upload() {
	var img = canvas.toDataURL();
	var stickers_html = Array.prototype.slice.call(document.querySelectorAll(".sticker"));
	var stickers_src = [];
	for (var i = 0; i < stickers_html.length; i++)
		stickers_src.push(stickers_html[i].src);
	if (!canvasIsEmpty(canvas)) {
		var xhttp = new XMLHttpRequest();
		xhttp.open('POST', 'upload.php');
		xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		var params = 'imageData=' + encodeURI(img);
		params += '&stickers='+JSON.stringify(stickers_src);
		xhttp.send(params);
		resetPreview();
		alert("Successfully uploaded image");
	}
}

function addSticker(sticker) {
	
	if (sticker == null) 
	document.querySelectorAll(".sticker").forEach(sticker => sticker.remove());
	else {
		var stickers = document.querySelectorAll(".sticker");
		var show = true;
		for (var i = 0; i < stickers.length; i++) {
			if (stickers[i].src == sticker.src) {
				stickers[i].remove();
				show = false;
			}
		}
		if (show) {
			var parent = document.getElementById('preview-wrapper');
			var stickerOverlay = document.createElement('img');
			stickerOverlay.setAttribute('id', 'sticker-overlay');
			stickerOverlay.setAttribute('class', 'sticker');
			stickerOverlay.setAttribute('src', sticker.src);
			parent.appendChild(stickerOverlay);
		}
	}
}
