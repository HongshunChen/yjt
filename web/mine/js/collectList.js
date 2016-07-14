var collectList = {
	data: {},
	dataInit: function() {
		collectList.fn.list_init();
	},

	fn: {
		list_init: function() {
			var urls = window.location.href;
			var type = urls.substring(urls.indexOf("=") + 1, urls.length);
			localStorage.setItem('questiontype', type);
			collectList.fn.collect_list(1);
		},

		collect_list: function(page) {
			$.ajax({
				type: "get",
				url: config.host + "/collect/getList",
				data: {
					token: localStorage.getItem('token'),
					questiontype: localStorage.getItem('questiontype'),
					page: page,
				},
				dataType: "jsonp",
				success:function(data){
					if(data.status==1){
						collectList.fn.dataFill(data);
					}else{
						window.location.href="../login_register/deng.html";
						//alert(data.data);
					}
				},
				error:function(){
					alert('网络异常');
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.list.length,
					list: list,
					qtype:localStorage.getItem('questiontype'),
				};
				var html = template('shoucangContent', data);
				document.getElementById('shoucang_content').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			collectList.dataInit();
		},
	}
}
$(function($) {
	collectList.fn.cordavaDataGet();
});