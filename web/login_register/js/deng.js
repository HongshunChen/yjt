var deng = {
	data: {},
	dataInit: function() {
	},
	eventBind: function() {},
	fn: {
		list_init: function() {},

		
		cordavaDataGet: function() {
			deng.dataInit();
			deng.eventBind();

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
							window.location.href = "../index/index.html";
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
	deng.fn.cordavaDataGet();
});