var wodedaijinquan = {
	data: {},
	dataInit: function() {
		//用户登陆判断
		$tokened=localStorage.getItem('token');
		if($tokened==null)
		{
			window.location.href="../login_register/deng.html";
		}
		wodedaijinquan.fn.initialize();
		wodedaijinquan.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			$.ajax({
					type: 'GET',
					url: config.host + "/coupon/list",
					data: {
						token:localStorage.getItem('token'),
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//成功操作
							wodedaijinquan.fn.dataFill(list);
						} else {
							$.alert(list.data);
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						$.alert('网络异常');
					}
				});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.length,
					list: list,
				};
				var html = template('daijinQuan', data);
				document.getElementById('daijin_quan').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				user_name: '用户姓名',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			wodedaijinquan.fn.tagFill();
		},
		cordavaDataGet: function() {
			wodedaijinquan.dataInit();
			wodedaijinquan.eventBind();

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
	wodedaijinquan.fn.cordavaDataGet();
});