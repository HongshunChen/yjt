var quanzhenmoni = {
	data: {},
	dataInit: function() {
		quanzhenmoni.fn.list_init();
	},
	
	fn: {
		list_init: function() {
			$.ajax({
				type:"get",
				url:config.host+"/exam/simulate",
				data:{
					token:localStorage.getItem('token'),
					areaid:1,
				},
				dataType:'jsonp',
				success:function(data){
					if(data.status==1){
						localStorage.setItem('questionid', data.data.id);
						quanzhenmoni.fn.dataFill(data);
					}else{
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
					list: list,
				};
				list.data.radioT=list.data.radio_list.length;
				list.data.multipleT=list.data.multiple_list.length;
				list.data.judgementT=list.data.judgement_list.length;
				var html = template('quanZhen', list.data);
				document.getElementById('quan_zhen').innerHTML = html;
			}
		},
		
		cordavaDataGet: function() {
			quanzhenmoni.dataInit();
			

		},
		
	}
}
$(function($) {
	quanzhenmoni.fn.cordavaDataGet();
});