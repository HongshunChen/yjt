var zhaohuimima = {
	data: {},
	dataInit: function() {
		//zhaohuimima.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {},
		dataFill: function(list) {},
		tagFill: function() {},
		initialize: function() {
			zhaohuimima.fn.tagFill();
		},
		cordavaDataGet: function() {
			zhaohuimima.dataInit();
			zhaohuimima.eventBind();

		},
		//重新获取密码
		get_pwd_again: function() {
			var number = document.getElementById('number').value;
			var pwd = document.getElementById('password').value;
			var pwd_again = document.getElementById('pwd_again').value;
			var code = document.getElementById('code').value;

			if (!config.validation.mobile(number)) {
				alert('请输入正确的手机号');
			} else if (pwd.length < 6 || pwd_again.length < 6) {
				alert('密码不能小于6位');
			} else if (pwd != pwd_again) {
				alert('两次密码不一致');
			} else {
				$.ajax({
					type: 'GET',
					url: config.host + "/password/back",
					data: {
						username: number,
						verifycode: code,
						userpassword: pwd,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//成功操作
							window.location.href = 'deng.html';
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
						username: number,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//获取验证码成功操作
							daojishi(60);
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
	}
}
$(function($) {
	zhaohuimima.fn.cordavaDataGet();
});