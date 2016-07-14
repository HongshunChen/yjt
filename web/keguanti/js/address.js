var address = {
	data: {},
	dataInit: function() {
		address.fn.list_init();
	},
	fn: {
		list_init: function() {
			$.ajax({
				type:"get",
				url:config.host+"/area/list",
				
				dataType:'jsonp',
				success:function(data){
					if(data.status==1){
						address.fn.dataFill(data);
					}else{
						alert(data.data);
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
					total: list.data.length,
					list: list,
				};
				var html = template('allAddress', list);
				document.getElementById('all_address').innerHTML = html;
			}
		},
		cordavaDataGet: function() {
			address.dataInit();
		},
	}
}
$(function($) {
	address.fn.cordavaDataGet();
});