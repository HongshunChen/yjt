var quanbujiexi = {
	data: {},
	dataInit: function() {
		quanbujiexi.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			var paper_id=localStorage.getItem('paper_id');
				$.ajax({
					type:"get",
					url:config.host+"/exam/paper/parse/list",
					data:{
						token:localStorage.getItem('token'),
						paper_id:paper_id,
						keytype:1,
					},
					dataType:"jsonp",
					success:function(data){
						if(data.status==1){
							quanbujiexi.fn.dataFill(data);
						}else{
							alert(data.daata);
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
					total:list.data.length,
					list: list,
				};
				var html = template('quanbuJiexi', list);
				document.getElementById('quanbu_jiexi').innerHTML = html;
			}
		},
		cordavaDataGet: function() {
			quanbujiexi.dataInit();
			quanbujiexi.eventBind();

		},
	}
}
$(function($) {
	quanbujiexi.fn.cordavaDataGet();
});