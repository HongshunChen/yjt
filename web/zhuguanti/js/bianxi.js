var bianxi = {
	data: {},
	dataInit: function() {
		bianxi.fn.list_init();
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
						
						if (list.status == 1) {
							//登录成功操作
							
						} else {
							$.alert(list.data);
						}
					},
					error: function(xhr, type) {
						var list=[{"name":"json"}];
						bianxi.fn.dataFill(list);
						console.log("请求失败");
						$.alert('网络异常');
					}
				});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
				
					list: list,
					
				};
				var html = template('bianXi', data);
				document.getElementById('bian_xi').innerHTML = html;
			}
		},
		
		cordavaDataGet: function() {
			bianxi.dataInit();
			
		},
	}
}
$(function($) {
	bianxi.fn.cordavaDataGet();
});