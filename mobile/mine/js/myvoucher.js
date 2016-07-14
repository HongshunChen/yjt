var myvoucher = {
	data: {},
	dataInit: function() {
		myvoucher.fn.initialize();
		myvoucher.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			$.ajax({
					type: 'GET',
					url: config.host + "/coupon/list",
					data: {
						token:localStorage.getItem('token'),
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//成功操作
							myvoucher.fn.dataFill(list);
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
				};
				var html = template('daijinQuan', data);
				document.getElementById('daijin_quan').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				user_name: '个人中心',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			myvoucher.fn.tagFill();
		},
		cordavaDataGet: function() {
			myvoucher.dataInit();
			myvoucher.eventBind();

		},
	}
}
$(function($) {
	myvoucher.fn.cordavaDataGet();
});