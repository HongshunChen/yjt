var jianda = {
	data: {},
	dataInit: function() {
//		jianda.fn.initialize();
		jianda.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
				$.ajax({
					type: 'GET',
					url: config.host + "home/dianping/getlist",
					data: {
						
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						jianda.fn.dataFill(list);
						if (list.status == 1) {
							//登录成功操作
							
						} else {
							alert(list.data);
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						var list=[{"name":"json"}];
						jianda.fn.dataFill(list);
//						alert('网络异常');
					}
				});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					
					list: list,
					
				};
				var html = template('jianDa', data);
				document.getElementById('jian_da').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				user_name: '密码',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			jianda.fn.tagFill();
		},
		cordavaDataGet: function() {
			jianda.dataInit();
			jianda.eventBind();

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

			
			}
		},
		//获取验证码
		get_code: function() {
			daojishi(60);
		},
	}
}
$(function($) {
	jianda.fn.cordavaDataGet();
});