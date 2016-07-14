var mykecheng_content = {
	data: {},
	dataInit: function() {
		mykecheng_content.fn.list_init();
	},
	fn: {
		list_init: function() {
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("=") + 1, urls.length);
			$.ajax({
				type: 'GET',
				url: config.host + "/course/detail",
				data: {
					courseid: id,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						mykecheng_content.fn.dataFill(list);
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};

				var html = template('Content', data);
				document.getElementById('content').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			mykecheng_content.dataInit();
		},
	}
}
$(function($) {
	mykecheng_content.fn.cordavaDataGet();
});