var forget_pwd = {
	data: {},
	dataInit: function() {
		forget_pwd.fn.initialize();

	},
	eventBind: function() {},
	fn: {

		tagFill: function() {
			var data = {
				bar_Title: '忘记密码',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			forget_pwd.fn.tagFill();
		},
		cordavaDataGet: function() {
			forget_pwd.data.my_user_id = "2232f48b-a214-4cc4-8a25-5c79d4db970f";
			forget_pwd.dataInit();
			forget_pwd.eventBind();
		},

		//忘记密码
		make_pwd: function() {
			var mobile = document.getElementById('mobile').value;
			var yanzheng = document.getElementById('verify-code').value;
			var mobiles = config.validation.mobile(mobile);
			var password = document.getElementById('password').value;

			if (!mobiles) {
				$.alert('请填写正确的手机号');
			} else if (password.length < 6) {
				$.alert('密码必须为6位以上');
			} else if (yanzheng == "") {
				$.alert('请填写验证码');
			} else {
				//重新设置密码
				var forget_pwdUrl = config.host + "/password/back";
				$.ajax({
					type: "get",
					url: forget_pwdUrl,
					data: {
						username: mobile,
						userpassword: password,
						verifycode: yanzheng,
					},
					dataType: 'jsonp',
					success: function(data) {
						console.log(data);
						if (data.status == 1) {
							$.alert(data.data);
							window.location.href = 'login.html';
						} else {
							$.alert(data.data);
						}
					},
					error: function(data) {
						$.alert('网络异常');
					}
				});
			}
		},
		getyanzheng: function() {
			var mobile = document.getElementById('mobile').value;
			var yan_mobile = config.validation.mobile(mobile);
			if (!yan_mobile) {
				$.alert('请填写正确的手机号');
			} else {
				console.log("获取手机验证码");
				$.ajax({
					type: "get",
					url: config.host + "/send_message",
					data: {
						username: mobile,
					},
					dataType: 'jsonp',
					success: function(data) {
						var state = data.status;
						if (state == 1) {
							//获取验证码成功操作
							daojishi(60);
						} else {
							$.alert(data.data);
						}
					},
					error: function(data) {
						$.alert('网络异常');
					}
				});
			}
		},
		//倒计时处理函数
		clockHandle: function(times) {
			var btn = document.getElementById("get-verify-warp");
			if (times <= 0) {
				btn.innerHTML = "<span id='get-verify'>重新获取</span>";
				sendFlag = true;
			} else {
				btn.innerHTML = times + " s";
				times -= 1;
				setTimeout(function() {
					forget_pwd.fn.clockHandle(times)
				}, 1000);
			}
		},
	}
}
Zepto(function($) {
	forget_pwd.fn.cordavaDataGet();
});