var userinfomation = {
	data: {},
	dataInit: function() {
		userinfomation.fn.initialize();

	},
	eventBind: function() {},
	fn: {

		tagFill: function() {
			var data = {
				bar_Title: '个人中心',
				ChaBuDaoXinXi: '查不到信息',
				user_name: JSON.parse(localStorage.getItem('userInfo')).nickname,
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			userinfomation.fn.tagFill();
		},
		cordavaDataGet: function() {
			userinfomation.dataInit();
			userinfomation.eventBind();
		},

		//修改昵称
		change_name: function() {
			var nickName = document.getElementById('nick_name').value;
			$.ajax({
				type: 'GET',
				url: config.host + "/user/info/update",
				data: {
					token: localStorage.getItem('token'),
					nickname: nickName,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					if (list.status == 1) {
						//登录成功操作
						$.alert('设置成功');
						userinfomation.fn.init_user();
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
		init_user: function() {
			//初始化用户信息
			$.ajax({
				type: 'GET',
				url: config.host + "/user/info",
				data: {
					token: localStorage.getItem('token'),
				},
				dataType: "jsonp",
				success: function(list) {
					if (list.status == 1) {
						console.log("请求成功");
						//成功操作
						var userInfo = list.data;
						localStorage.setItem('userInfo', JSON.stringify(userInfo));
						history.go(0);
					} else {
						$.alert(list.data);
						window.location.href = "../login_register/login.html";
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});
		},
		change_pwd: function() {
			var oldpwd = document.getElementById('oldpwd').value;
			var newpwd = document.getElementById('newpwd').value;
			var again_pwd = document.getElementById('again_pwd').value;
			if (oldpwd.length < 6 || newpwd.length < 6 || again_pwd.length < 6) {
				$.alert('密码不能小于6位');
			} else if (newpwd != again_pwd) {
				$.alert('两次输入的密码不一致');
			} else {
				$.ajax({
					type: 'GET',
					url: config.host + "/pssword/retrieve",
					data: {
						token: localStorage.getItem('token'),
						old_userpassword: oldpwd,
						new_userpassword: newpwd,
					},
					dataType: "jsonp",
					success: function(list) {
						if (list.status == 1) {
							console.log("请求成功");
							//登录成功操作
							window.location.href = '../login_register/login.html';
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
		zhao_pwd:function(){
			window.location.href='../login_register/forget_pwd.html';
		},
	}
}
Zepto(function($) {
	userinfomation.fn.cordavaDataGet();
});