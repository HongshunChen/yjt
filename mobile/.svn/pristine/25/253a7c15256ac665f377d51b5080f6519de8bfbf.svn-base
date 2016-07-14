var home_teachercomments = {
	data: {
	},
	dataInit: function() {
		home_teachercomments.fn.initialize();
		home_teachercomments.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
		   var token=localStorage.getItem('token');
		   var baby_id=JSON.parse(localStorage.getItem('babyOne')).id;
				$.ajax({
					type: 'GET',
					url: config.host + "home/dianping/getlist",
					data: {
						token:token,
						baby_id:baby_id,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						if(list.status==1){
							home_teachercomments.fn.dataFill(list);
						}else{
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
					host:localStorage.getItem('file'),
				};
				var html = template('list_kq_content', data);
				document.getElementById('teacherComment_list').innerHTML = html;
			}
		},
		tagFill: function() {
			var data = {
				bar_Title: '这是个标题',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			home_teachercomments.fn.tagFill();
		},
		cordavaDataGet: function() {
			home_teachercomments.dataInit();
			home_teachercomments.eventBind();
			
		},
	}
}
Zepto(function($) {
	home_teachercomments.fn.cordavaDataGet();
});