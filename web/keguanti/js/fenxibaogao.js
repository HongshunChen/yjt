var fenxibaogao = {
	data: {},
	dataInit: function() {
		fenxibaogao.fn.list_init();
	},
	fn: {
		list_init: function() {
			var paperid = localStorage.getItem('paper_id');
			$.ajax({
				type: "get",
				url: config.host + "/exam/getReport",
				data: {
					token: localStorage.getItem('token'),
					paper_id: paperid,
				},
				dataType: 'jsonp',
				success: function(data) {
					if (data.status == 1) {
						fenxibaogao.fn.dataFill(data);
						
						//获取代金券
						fenxibaogao.fn.getCoupon(paperid);
					} else {
						alert(data.data);
					}
				},
				errror: function() {
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
				var scored=list.data.scored;
				if(scored<10){
					list.data.scored='0'+list.data.scored;
					
				}
				
				//list.data.err_num
				var err_num=list.data.err_num;
				if(err_num<10){
					list.data.err_num='0'+list.data.err_num;
					
				}
				
				//list.data.couponvalue
				var couponvalue=list.data.couponvalue;
				if(couponvalue<10){
					list.data.couponvalue='0'+list.data.couponvalue;
					
				}
				
				var html = template('cuoTi', data);
				document.getElementById('fen_xi').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			fenxibaogao.dataInit();
		},
		//获取代金券
		
		getCoupon:function(id){
			
			$.ajax({
				type:"get",
				url:config.host+"/exam/getCoupon",
				data:{
					token: localStorage.getItem('token'),
					paper_id: id,
				},
				dataType:"jsonp",
				success:function(data){
					if(data.status==1){
						//alert('成功获取优惠券')
					}else{
						alert(data.data);
					}
				},
				error:function(){
					alert('网络异常');
				}
			})
		},
		
	},
}
$(function($) {
	fenxibaogao.fn.cordavaDataGet();
});