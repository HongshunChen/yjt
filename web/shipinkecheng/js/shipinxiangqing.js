var shipinxiangqing = {
	data: {},
	dataInit: function() {
		shipinxiangqing.fn.list_init();
	},
	fn: {
		list_init: function() {
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("=") + 1, urls.length);
			shipinxiangqing.fn.teacher_list();
			$.ajax({
				type: 'GET',
				url: config.host + "/course/detail",
				data: {
					courseid: id,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						shipinxiangqing.fn.dataFill(list);
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
		
		teacher_list:function(){
			$.ajax({
				type: 'GET',
				url: config.host + "/teachers",
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						shipinxiangqing.fn.teacher_Fill(list);
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
					files:config.files,
					list: list,
				};

				var html = template('shipinXiangqing', data);
				document.getElementById('shipin_xiangqing').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			shipinxiangqing.dataInit();
		},
		
		shipin_by:function(id){
			
			$.ajax({
				type:"get",
				url:config.host+"/course/create",
				data:{
					token:localStorage.getItem('token'),
					courseid:id,
				},
				dataType:"jsonp",
				success:function(data){
					var d = document.getElementById('courseid').value;
					window.location.href="location='../payment/payment.html?t=1&id='+d";
					if(data.status==1){
						window.location.href="location='../payment/payment.html?t=1&id=courseid'";
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
	shipinxiangqing.fn.cordavaDataGet();
});