var jianda = {
	data: {},
	dataInit: function() {
		jianda.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			var token = localStorage.getItem('token');
			if (token != null) {
				var urls = window.location.href;
				var type = urls.substring(urls.indexOf("=") + 1, urls.length);
				$.ajax({
					type: 'GET',
					url: config.host + "/exam/create",
					data: {
						token: localStorage.getItem('token'),
						keytype: 1,
						questid: type,
						areaid: 0,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							localStorage.setItem('paper_id', list.data.paper_id);
							//						试卷类型
							localStorage.setItem('keytype', list.data.keytype);
							//						试题类型
							localStorage.setItem('questid', list.data.questid);
							localStorage.setItem('total', list.data.total_count);
							jianda.fn.getOne(1);
						} else {
							$.alert(list.data);
						}
					},
					error: function(xhr, type) {

						console.log("请求失败");
						$.alert('网络异常');
					}
				});
			} else {
				$.confirm('您还没有登录，是否要登录?', function() {
					window.location.href = '../login_register/login.html';
				});

			}
		},
		getOne: function(no) {
			$.ajax({
				type: "get",
				url: config.host + "/exam/getOne",
				data: {
					token: localStorage.getItem('token'),
					paper_id: localStorage.getItem('paper_id'), //试卷主键id
					question_no: no,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('shiti_id', data.data.id);
						jianda.fn.dataFill(data);
					} else {
						//$.alert(data.data);
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
					questid: localStorage.getItem('questid'),
					total: localStorage.getItem('total'),
				};
				var html = template('jianDa', data);
				document.getElementById('jianda').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			jianda.dataInit();
			jianda.eventBind();
		},
		//下一题
		next: function(next) {
			if(next == 0) {
				alert('没有下一题了');
			} else {
				jianda.fn.submitOne(next);
			}
		},

		prev: function(no) {
			jianda.fn.getOne(no);
		},
		submitOne: function (next) {
			var _url = config.host + '/exam/submitOne';

			var img = $("#images").attr('src');

			if (!img) {
				$.alert("未选择图片");
			} else {
				//var img = document.getElementById('images');
				var _data = {
					token: localStorage.getItem('token'),
					paper_question_id: localStorage.getItem('shiti_id'),
					answertype: 2,
					answered: img
				}
				http_request(_url, _data, function (data) {
					jianda.fn.getOne(next);
				}, null, 'json', 'post');
			}
		}
	}
}
Zepto(function($) {
	jianda.fn.cordavaDataGet();
});