var shoucangList = {
	data: {},
	dataInit: function() {
		shoucangList.fn.initialize();
		shoucangList.fn.list_init();
	},

	fn: {
		list_init: function() {
			var urls = window.location.href;
			var type = urls.substring(urls.indexOf("=") + 1, urls.length);
			localStorage.setItem('questiontype', type);
			shoucangList.fn.collect_list(1);
		},

		collect_list: function(page) {
			$.ajax({
				type: "get",
				url: config.host + "/collect/getList",
				data: {
					token: localStorage.getItem('token'),
					questiontype: localStorage.getItem('questiontype'),
					page: page,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						shoucangList.fn.dataFill(data);
					} else {
						$.alert(data.data);
					}
				},
				error: function() {
					$.alert('网络异常');
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.list.length,
					list: list,
					qtype: localStorage.getItem('questiontype'),
				};
				var html = template('shoucangContent', data);
				document.getElementById('shoucang_content').innerHTML = html;
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
			shoucangList.fn.tagFill();
		},
		cordavaDataGet: function() {
			shoucangList.dataInit();
		},
	}
}
$(function($) {
	shoucangList.fn.cordavaDataGet();
});