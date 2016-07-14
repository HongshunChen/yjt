var cuotijiexi = {
	data: {},
	dataInit: function() {
		cuotijiexi.fn.list_init();
	},
	fn: {
		list_init: function() {
			$.ajax({
				type:"get",
				url:config.host+"/exam/errState",
				data:{
					token:localStorage.getItem('token'),
					paper_id:localStorage.getItem('paper_id'),
				},
				dataType:'jsonp',
				success:function(data){
					if(data.status==1){
						cuotijiexi.fn.error_analyze(data);
						cuotijiexi.fn.dataFill(data);
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
				var html = template('cuoJie', list.data);
				document.getElementById('cuo_jie').innerHTML = html;
			}
		},
		cordavaDataGet: function() {
			cuotijiexi.dataInit();
		},
		//错题解析
		error_analyze:function(list){
			var lth=list.data.err_list.length;
			for (var i=0;i<lth;i++) {
				$.ajax({
					type:"get",
					url:config.host+"/exam/parsePaper",
					data:{
						token:localStorage.getItem('token'),
						paper_id:localStorage.getItem('paper_id'),
						question_no:list.data.err_list[i].question_no,
					},
					dataType:"jsonp",
					success:function(data){
						if(data.status==1){

							cuotijiexi.fn.errorFail(data);
						}else{
							alert(data.data);
						}
					},
					error:function(){
						alert('网络异常');
					}
				});
			}			
		},
		errorFail:function(list){
			if (list) {
				var data = {
					list: list,
				};
				console.log(list.data.question_no);
				var html = template('jieXis', list.data);
				document.getElementById('jie_xi').innerHTML += html;
			}
		}
	}
}
$(function($) {
	cuotijiexi.fn.cordavaDataGet();
});