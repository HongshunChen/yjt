var index = {
	data: {},
	dataInit: function() {
		index.fn.list_init();
	},
	fn: {
		list_init: function() {
			var token = localStorage.getItem('token');
			if (token != null) {
				//初始化用户信息
				$.ajax({
					type: 'GET',
					url: config.host + "/user/info",
					data: {
						token: localStorage.getItem('token'),
					},
					dataType: "jsonp",
					success: function(list) {
						if (list.status == 1) {
							console.log("请求成功");
							//成功操作
							var userInfo = list.data;
							localStorage.setItem('userInfo', JSON.stringify(userInfo));
							console.log(JSON.parse(localStorage.getItem('userInfo')).username);
							console.log('存放成功');
						} else {
							alert(list.data);
							window.location.href="login/denglu.html";
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						alert('网络异常');
					}
				});
			}
			//初始化文件目录
			$.ajax({
				type: "get",
				url: config.host + "/init",
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('file', data.data.file_root);
					} else {
						alert(data.data);
					}
				},
				error: function() {
					alert("网络异常");
				}
			});

			
		},

		cordavaDataGet: function() {
			index.dataInit();
		},
	}
}
$(function($) {
	index.fn.cordavaDataGet();
});