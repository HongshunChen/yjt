var shoucangdan = {
	data: {},
	dataInit: function() {
		shoucangdan.fn.list_init();
	},

	fn: {
		list_init: function() {
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("=") + 1, urls.length);
			$.ajax({
				type: "get",
				url: config.host + "/collect/getOne",
				data: {
					token: localStorage.getItem('token'),
					favorid: id,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						shoucangdan.fn.dataFill(data);
					} else {
						window.location.href="../login_register/deng.html";
						//alert(data.data);
					}
				},
				error: function() {
					alert("网络异常");
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					list: list,
					qtype: localStorage.getItem('questiontype'),
				};
				var html = template('shoucangContent', data);
				document.getElementById('shoucang_content').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			shoucangdan.dataInit();
		},
		
	}
}
$(function($) {
	shoucangdan.fn.cordavaDataGet();
});