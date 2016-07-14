//重新封装http请求, 需要jquery库的支持
function http_request(url, data, succ_callback, err_callback, dataType, type, requestTimes) {

	if (!arguments[3]) err_callback = null;
	if (!arguments[4]) dataType = "jsonp";
	if (!arguments[5]) type = "get";
	if (!arguments[6]) requestTimes = 0;

	$.ajax({
		type: type,
		url: url,
		data: data,
		dataType: dataType,
		success: function(data) {

			var status = data.status;

			if (status) {
				succ_callback(data.data);
			} else {
				if (err_callback != null) {
					err_callback();
				} else {
					$.alert(data.data);
				}
			}
		},
		error: function(xhr, type) {

			requestTimes++;
			if (requestTimes < 3) {
				http_request(url, data, succ_callback, err_callback, dataType, type, requestTimes);
			} else {
				console.log("网络异常")
				$.alert("网络异常");
			}

		}
	});
}

//文件上传,需要依赖dcloud api (mui.js)的支持
function createUpload(uploadUrl, filePath, params, callback) {
	var task = plus.uploader.createUpload(uploadUrl, {
			method: "POST",
			blocksize: 204800,
			priority: 100
		},
		function(t, status) {
			if (callback) {
				callback(t, status);
			} else {
				// 上传完成
				if (status == 200) {
					console.log("Upload success ");
				} else {
					console.log("Upload failed: ");
				}
			}
		}
	);
	var paramsLen = params.length;
	for (var i = 0; i < paramsLen; i++) {
		for (var j in params[i]) {
			task.addData(j, params[j]);
		}
	}
	task.addFile(filePath, {
		key: "file"
	});
	task.start();
}