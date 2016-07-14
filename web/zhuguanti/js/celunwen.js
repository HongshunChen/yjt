var celunwen = {
	data: {},
	dataInit: function() {
		celunwen.fn.initialize();
		celunwen.fn.list_init();
	},
	eventBind: function() {
		
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
						celunwen.fn.dataFill(list);
						if (list.status == 1) {
							//登录成功操作
							
						} else {
							$.alert(list.data);
						}
					},
					error: function(xhr, type) {
						var list=[{"name":"json"}];
						celunwen.fn.dataFill(list);
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
				var html = template('ceLun', data);
				document.getElementById('ce_lun').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				user_name: '用户名',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			celunwen.fn.tagFill();
		},
		cordavaDataGet: function() {
			celunwen.dataInit();
			celunwen.eventBind();

		},
	}
}
$(function($) {
	celunwen.fn.cordavaDataGet();
});