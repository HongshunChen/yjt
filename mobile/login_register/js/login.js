var login = {
	data: {},
	dataInit: function() {
		login.fn.initialize();
		login.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
//			var file = localStorage.getItem('file');
//			if (file == null) {
//				//初始化数据
//				$.ajax({
//					type: "get",
//					url: config.host + "index/init",
//					dataType: "jsonp",
//					success: function(data) {
//						if (data.status == 1) {
//							console.log("success init");
//							localStorage.setItem('file', data.data.file_document);
//						} else {
//							console.log("failed init");
//						}
//					},
//					error: function() {
//						$.alert('网络异常');
//					}
//				});
//			}
		},
		tagFill: function() {
			var data = {
				bar_Title: '登录',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			login.fn.tagFill();
		},
		cordavaDataGet: function() {
			login.dataInit();
			login.eventBind();
		},
		//用户登录
		login: function() {
			var number = document.getElementById('number').value;
			var pwd = document.getElementById('password').value;
			if (!config.validation.mobile(number)) {
				alert('请输入正确的手机号');
			} else if (pwd.length < 6) {
				alert('密码不能小于6位');
			} else {
				$.ajax({
					type: 'GET',
					url: config.host + "/login",
					data: {
						username: number,
						userpassword: pwd,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//登录成功操作
							localStorage.setItem("token",list.data.token);
							window.location.href = "../main.html";
						} else {
							alert(list.data);
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						alert('网络异常');
					}
				});
			}
		
		},
		forget_password: function() {
			window.location.href = "forget_pwd.html";
		}
	}
}
Zepto(function($) {
	login.fn.cordavaDataGet();
});