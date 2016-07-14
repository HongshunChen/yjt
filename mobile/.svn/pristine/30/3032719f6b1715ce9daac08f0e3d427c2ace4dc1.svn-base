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
			if (!number || !pwd) {
				$.alert("手机和密码不能为空");
			} else {
				var yan_num = config.validation.mobile(number);
				var yan_pwd = pwd.length;
				if (!yan_num) {
					$.alert('手机号格式不正确');
				} else if (yan_pwd < 6) {
					$.alert('密码6位以上');
				} else {
					$.ajax({
						type: "get",
						url: config.host + "user/user/getTokenByPwd",
						data: {
							mobile: number,
							password: pwd,
						},
						dataType: 'jsonp',
						success: function(data) {
							
							//清除之前登录帐号的数据
							localStorage.clear();
							
							if (data.status == 1) {
								
								var token = data.data.token;
								
								localStorage.setItem('token', token);
								
								var loginUrl = config.host + "user/user/getUserInfo";
								$.ajax({
									type: "get",
									url: loginUrl,
									dataType: 'jsonp',
									data: {
										token: token,
									},
									success: function(data) {
										if (data.status == 1) {
											
											var userInfo = data.data;
											localStorage.setItem('userInfo', JSON.stringify(userInfo));
											localStorage.setItem('skin', JSON.parse(localStorage.getItem('userInfo')).skin);

											window.location.href = "../home/main.html";
											//登录成功之后获取baby列表
//											$.ajax({
//												type: "get",
//												url: config.host + "home/baby/getList",
//												dataType: "jsonp",
//												data: {
//													token: token,
//												},
//												success: function(data) {
//													if (data.status == 1) {
//														//默认为第一个baby
//														var id = data.data[0].id;
//														//根据id获取baby的详情
//														$.ajax({
//															type: "get",
//															url: config.host + "home/baby/getOne",
//															dataType: "jsonp",
//															data: {
//																token: token,
//																baby_id: id,
//															},
//															success: function(data) {
//																if (data.status == 1) {
//																	localStorage.setItem('babyOne', JSON.stringify(data.data));
//																} else {
//																	$.alert(data.data);
//																}
//																window.location.href = "../home/main.html";
//															},
//															error: function() {
//																$.alert('网络异常');
//															}
//														});
//													} else {
//														window.location.href = "../home/main.html";
//													}
//												},
//												error: function() {
//													$.alert('网络异常');
//												}
//											});
										} else {
											$.alert(data.data);
										}
									},
									error: function(data) {
										$.alert('网络异常');
									}
								});
							} else {
								$.alert(data.data);
							}
						},
						error: function(data) {
							$.alert('网络异常');
						}
					});
				}
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