var register_next = {
	data: {},
	dataInit: function() {
		register_next.fn.initialize();

	},
	eventBind: function() {},
	fn: {

		tagFill: function() {
			var data = {
				bar_Title: '注册',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			register_next.fn.tagFill();
		},
		cordavaDataGet: function() {
			register_next.dataInit();
			register_next.eventBind();
		},
		register_finish: function() {
			var url = location.href;
			var mobile = url.substring(url.indexOf("=") + 1, url.length);
			var username = document.getElementById('name').value;
			var password = document.getElementById('password').value;
			if (password.length < 6) {
				$.alert('请设置6位以上的密码');
			} else {
				//注册
				var regUrl = config.host + "user/user/reg";
				$.ajax({
					type: "get",
					url: regUrl,
					data: {
						mobile: mobile,
						password: password,
						username: username,
					},
					dataType: "jsonp",
					success: function(data) {
						var state = data.status;
						if (state == 1) {
							//返回token
							localStorage.setItem('token', data.data.token);
							var token = localStorage.getItem('token');
							//获取用户信息
							var loginUrl = config.host + "user/user/getUserInfo";
							$.ajax({
								type: "get",
								url: loginUrl,
								dataType: 'jsonp',
								data: {
									token: token,
								},
								success: function(data) {
									if (data.status == 1) {
										var userInfo = data.data;
										localStorage.setItem('userInfo', JSON.stringify(userInfo));
										//登录成功之后初始化数据
										$.ajax({
											type: "get",
											url: config.host + "index/init",
											dataType: "jsonp",
											success: function(data) {
												if (data.status == 1) {
													localStorage.setItem('file', data.data.file_document);
													window.location.href = "index.html";
												} else {
													$.alert(data.data);
												}
											},
											error: function() {
												$.alert('网络异常');
											}
										});
									} else {
										$.alert(data.data);
									}
								},
								error: function(data) {
									$.alert('网络异常');
								}
							});
						} else {
							$.alert(data.data);
						}
					},
					error: function(data) {
						$.alert('网络异常');
					}
				})
			}
		},
	}
}
Zepto(function($) {
	register_next.fn.cordavaDataGet();
});