function getFileUrl(sourceId) {
	var url;
	if (navigator.userAgent.indexOf("MSIE") >= 1) { // IE 
		url = document.getElementById(sourceId).value;
	} else if (navigator.userAgent.indexOf("Firefox") > 0) { // Firefox 
		url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
	} else if (navigator.userAgent.indexOf("Chrome") > 0) { // Chrome 
		url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
	}
	return url;
}
/** 
 * 将本地图片 显示到浏览器上 
 */
function preImg(sourceId, targetId) {
	var url = getFileUrl(sourceId);
	var imgPre = document.getElementById(targetId);
	imgPre.src = url;
}

function show_img(ats, img_id) {
	var file = ats.files[0];
	var imageType = /image.*/;
	if (file.type.match(imageType)) {
		var reader = new FileReader();
		reader.onload = function() {
			var img = new Image();

			img.src = reader.result;
			img.className="images";
			var div0 = document.createElement('div');
			div0.className = "div0";
			var div = document.createElement('div');
			div.className = "ing";
			div.appendChild(img);

			$(img_id).append(div0);

			div0.appendChild(div);
			div.appendChild(img);
			var div1 = document.createElement("div");
			div1.id = "div1";

			div.appendChild(div1);
			div1.innerHTML = "X";
			div1.className = "close";

			div1.onclick = function() {
				div1.parentNode.parentNode.parentNode.removeChild(div1.parentNode.parentNode);
			}

		};
		reader.readAsDataURL(file);
	} else {
		alert(opts.errorMessage);
	}
}

function upload_img(id, answer) {
	$.ajax({
		type: "get",
		url: config.host + "/exam/submitOne",
		data: {
			token: localStorage.getItem('token'),
			paper_question_id: id,
			answertype: 2,
			answered: answer,
		},
		dataType: "jsonp",
		success: function(data) {
			if (data.status == 1) {
				alert('提交成功');
			} else {
				alert(data.data);
			}
		},
		error: function() {
			alert('网络异常');
		}
	});
}