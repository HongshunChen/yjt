var payment = {
	data: {},
	dataInit: function() {
		payment.fn.list_init();
	},
	fn: {
		list_init: function() {
			var token = localStorage.getItem('token');
                        var urlstr = config.geturlstr('id');
                        var price = config.geturlstr('price');
                        var t = config.geturlstr('t');
                        if(t=='video'){t='视频';}
                        if(t=='zhiboke'){t='直播';}
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
                                                        document.getElementById('cn').innerHTML = '一讲堂'+t+'课程';
                                                        document.getElementById('price').innerHTML = price;
						} else {
							//alert(list.data);
							//window.location.href="../login_register/deng.html";
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						alert('网络异常');
					}
				});
			}			
		},

		cordavaDataGet: function() {
			payment.dataInit();
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					list: list,
				};
				var html = template('zhu_ye', data);
				document.getElementById('zhuYe').innerHTML = html;
			}
		},
	}
}
$(function($) {
	payment.fn.cordavaDataGet();
});