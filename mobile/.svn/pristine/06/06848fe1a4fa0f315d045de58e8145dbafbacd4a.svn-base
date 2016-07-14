var register = {
	data: {},
	dataInit: function() {
		register.fn.initialize();
		//		register.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.length,
					list: list,
					host: localStorage.getItem('file'),
				};
				var html = template('list_kq_content', data);
				document.getElementById('teacherComment_list').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				bar_Title: '注册',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			register.fn.tagFill();
		},
		cordavaDataGet: function() {
			register.dataInit();
			register.eventBind();

		},
		//用户注册
		register: function() {
			var number = document.getElementById('number').value;
			var pwd = document.getElementById('password').value;
			var pwd_again = document.getElementById('pwd_again').value;
			var codes = document.getElementById('code').value;

			if (!config.validation.mobile(number)) {
				$.alert('请输入正确的手机号');
			} else if (pwd.length < 6 || pwd_again.length < 6) {
				$.alert('密码不能小于6位');
			} else if (pwd != pwd_again) {
				$.alert('两次密码不一致');
			} else {

				$.ajax({
					type: 'GET',
					url: config.host + "/reg",
					data: {
						username: number,
						userpassword: pwd,
						verifycode: codes,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//登录成功操作
							localStorage.setItem('token', list.data.token);
							console.log(localStorage.getItem('token'));
							window.location.href = "../main.html";
						} else {
							$.alert(list.data);
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						$.alert('网络异常');
					}
				});
			}
		},
		//获取验证码
		get_code: function() {
			var number = document.getElementById('number').value;
			if (!config.validation.mobile(number)) {
				alert('请输入正确的手机号');
			} else {
				$.ajax({
					type: 'GET',
					url: config.host + "/send_message",
					data: {
						username:number,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//获取验证码成功操作
							daojishi(60);
						} else {
							$.alert(list.data);
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						$.alert('网络异常');
					}
				});
			}
		},
	}
}
$(function($) {
	register.fn.cordavaDataGet();
});