var chakanquanbu = {
	data: {},
	dataInit: function() {
		chakanquanbu.fn.initialize();
		//		chakanquanbu.fn.list_init();
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
				bar_Title: '找回密码',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			chakanquanbu.fn.tagFill();
		},
		cordavaDataGet: function() {
			chakanquanbu.dataInit();
			chakanquanbu.eventBind();

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
					url: config.host + "home/dianping/getlist",
					data: {
						token: token,
						baby_id: baby_id,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if (list.status == 1) {
							//登录成功操作
							chakanquanbu.fn.dataFill(list);
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
			daojishi(60);
		},
	}
}
$(function($) {
	chakanquanbu.fn.cordavaDataGet();
});