var zhibojieshao = {
	data: {},
	dataInit: function() {
		zhibojieshao.fn.list_init();
	},
	fn: {
		list_init: function() {
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("=") + 1, urls.length);
			zhibojieshao.fn.teacher_list();
			$.ajax({
				type: 'GET',
				url: config.host + "/course/livedetail",
				data: {
					vid:id,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					
					if (list.status == 1) { 
						//成功操作
						zhibojieshao.fn.dataFill(list);
					} else {
						alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					alert('网络异常');
				}
			});
		},
		
		teacher_list:function(){
			$.ajax({
				type: 'GET',
				url: config.host + "/teachers",
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						zhibojieshao.fn.teacher_Fill(list);
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
		teacher_Fill: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};

				var html = template('teacherList', data);
				document.getElementById('teacher_list').innerHTML = html;
			}
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					list: list,
				};
				var html = template('zhiboKe', data);
				document.getElementById('zhibo_ke').innerHTML = html;
			}
		},
		cordavaDataGet: function() {
			zhibojieshao.dataInit();
		},
		zhibo_by:function(id){
			
			$.ajax({
				type:"get",
				url:config.host+"/course/create",
				data:{
					token:localStorage.getItem('token'),
					courseid:id,
				},
				dataType:"jsonp",
				success:function(data){
					if(data.status==1){
						alert('购买成功');
					}else{
						alert(data.data);
					}
				},
				error:function(){
					alert('网络异常');
				}
			});
			}
	}
}
$(function($) {
	zhibojieshao.fn.cordavaDataGet();
});