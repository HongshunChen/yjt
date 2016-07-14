var shipinxiangqing = {
	data: {},
	dataInit: function() {
		shipinxiangqing.fn.list_init();
	},
	fn: {
		list_init: function() {
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("=") + 1, urls.length);
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
					if(data.status==1){
						alert('购买成功');
						window.location.href="../mine/mykecheng.html";
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