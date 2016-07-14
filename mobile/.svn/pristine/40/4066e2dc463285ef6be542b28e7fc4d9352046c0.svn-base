var register = {
	data: {},
	dataInit: function() {
		register.fn.initialize();

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
			register.fn.tagFill();
		},
		cordavaDataGet: function() {
			register.dataInit();
			register.eventBind();
		},

		//下一步
		register_next: function() {
			var mobile = document.getElementById('mobile').value;
			var yanzheng = document.getElementById('verify-code').value;
			var mobiles = config.validation.mobile(mobile);
			if (!mobiles) {
				$.alert('请填写正确的手机号')
			} else if (yanzheng == "") {
				$.alert('请填写验证码');
			} else {
				//检查验证码是否合法
				var verifyCheckUrl = config.host + "user/user/checkCode";
				$.ajax({
					data: {
						mobile:mobile,
						code: yanzheng,
					},
					url:verifyCheckUrl,
					type: "get",
					dataType: "jsonp",
					success: function(data) {
						var state = data.status;
						if (state == "1") {
							window.location.href = "register_next.html?mobile=" + mobile;
						}else{
							$.alert(data.data);
						}
					},
					error:function(data){
						$.alert('网络异常');
					}
				})
			}
		},
		getyanzheng: function() {
			var mobile = document.getElementById('mobile').value;
			var yan_mobile = config.validation.mobile(mobile);
			if (!yan_mobile) {
				$.alert('请填写正确的手机号');
			} else {
				console.log("12asd");
				$.ajax({
					type: "get",
					url: config.host + "user/user/getVerifyCode",
					data: {
						mobile: mobile,
					},
					dataType: 'jsonp',
					success: function(data) {
						var state = data.status;
						if (state == 1) {
							register.fn.clockHandle(60);
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
					register.fn.clockHandle(times)
				}, 1000);
			}
		},
	}
}
Zepto(function($) {
	register.fn.cordavaDataGet();
});