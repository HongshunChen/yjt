var gongwenxiezuo = {
	data: {},
	dataInit: function() {
		gongwenxiezuo.fn.list_init();
	},
	fn: {
		list_init: function() {
			$.ajax({
				type: 'GET',
				url: config.host + "home/dianping/getlist",
				data: {

				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					gongwenxiezuo.fn.dataFill(list);
					if (list.status == 1) {
						//登录成功操作

					} else {
						alert(list.data);
					}
				},
				error: function(xhr, type) {
					var list=[{"name":"json"}];
					gongwenxiezuo.fn.dataFill(list);
					console.log("请求失败"); 
//					alert('网络异常');
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					
					list: list,
					
				};
				var html = template('gongWen', data);
				document.getElementById('gong_wen').innerHTML = html;
			}
		},
		
		cordavaDataGet: function() {
			gongwenxiezuo.dataInit();

		},
	}
}
$(function($) {
	gongwenxiezuo.fn.cordavaDataGet();
});