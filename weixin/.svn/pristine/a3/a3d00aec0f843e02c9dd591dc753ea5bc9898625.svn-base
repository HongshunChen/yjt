var jiandashoucang = {
	data: {},
	dataInit: function() {
		jiandashoucang.fn.initialize();
		jiandashoucang.fn.list_init();
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
						jiandashoucang.fn.dataFill(data);
					} else {
						$.alert(data.data);
					}
				},
				error: function() {
					$.alert("网络异常");
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
			jiandashoucang.dataInit();
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
			jiandashoucang.fn.tagFill();
		},
		delete_collect: function(id) {
			$.confirm('确定要删除吗？', function() {
				$.ajax({
					type: "get",
					url: config.host + "/collect/update",
					data: {
						token: localStorage.getItem('token'),
						questionid: id,
					},
					dataType: "jsonp",
					success: function(data) {
						if (data.status == 1) {
							window.location.href = 'classiccollection.html';
						} else {
							$.alert(data.data);
						}
					},
					error: function() {
						$.alert('网络异常');
					}
				})
			})
		},

	}
}
$(function($) {
	jiandashoucang.fn.cordavaDataGet();
});