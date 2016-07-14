var personalcenter = {
	data: {},
	dataInit: function() {
		personalcenter.fn.initialize();
		//		personalcenter.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			$.ajax({
				type: 'GET',
				url: config.host + "",
				data: {

				},
				dataType: "jsonp",
				success: function(list) {
					if (list.status == 1) {
						console.log("请求成功");
						personalcenter.fn.dataFill(list);
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
					total: list.data.length,
					list: list,
					host: localStorage.getItem('file'),
				};
				var html = template('list_kq_content', data);
				document.getElementById('notice_list').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				bar_Title: '系统设置',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			personalcenter.fn.tagFill();
		},
		cordavaDataGet: function() {
			personalcenter.dataInit();
			personalcenter.eventBind();
		},
		quit: function() {
			
			$.confirm('你确定要退出吗?', function() {
				localStorage.clear();
				window.location.href='../login_register/login.html';
			});
		}
	}
}
Zepto(function($) {
	personalcenter.fn.cordavaDataGet();
});