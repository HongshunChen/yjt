function share(tag) {
	var aNods = $(".questionselect > p");
	var contents = '';
	for (var i = 0; i < aNods.length; i++) {
		contents += aNods[i].innerText + "  ";
	}
	var title = document.getElementById('title').innerText;
	var id = 'http://www.jiathis.com/send/?webid=';
	var url = window.location.href;
	if (tag == 'wx') {
		id += 'weixin';
	} else if (tag == 'bd') {
		id += 'tieba';
	} else if (tag == 'kj') {
		id += 'qzone';
	} else if (tag == 'xl') {
		id += 'tsina';
	} else if (tag == 'qq') {
		id += 'cqq';
	} else if (tag == 'rr') {
		id += 'renren';
	}
	var t = id + "&url=" + url + "&title=" + title + "&summary=" + contents;
	window.location.href = t;
}

function share_quan(title,content,tag) {
	alert(title);
	alert(content);
	var id = 'http://www.jiathis.com/send/?webid=';
	var url = window.location.href;
	if (tag == 'wx') {
		id += 'weixin';
	} else if (tag == 'bd') {
		id += 'tieba';
	} else if (tag == 'kj') {
		id += 'qzone';
	} else if (tag == 'xl') {
		id += 'tsina';
	} else if (tag == 'qq') {
		id += 'cqq';
	} else if (tag == 'rr') {
		id += 'renren';
	}
	var t = id + "&url=" + url + "&title=" + title + "&summary=" + content;
	window.location.href = t;
	
}