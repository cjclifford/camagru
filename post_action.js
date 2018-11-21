function like(post) {
	var pid = post.parentElement.parentElement.id;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "false")
				loadDoc('signup');
			else
				location.reload();
		}
	}
	xhttp.open("POST", "like.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var params = 'id_post=' + pid;
	xhttp.send(params);
}

function comment(post) {
	var pid = post.parentElement.parentElement.id;
	var comment = document.getElementById(pid).querySelector('.comment-box').value;
	if (comment && comment != '') {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "false") 
					loadDoc('signup');
				else 
					location.reload();
			}
		}
		xhttp.open("POST", "comment.php");
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var params = 'id_post=' + pid + '&comment=' + comment;
		xhttp.send(params);
	}
}
