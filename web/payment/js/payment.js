var payment = {
	data: {},
	dataInit: function() {
		payment.fn.list_init();
	},
	fn: {
		list_init: function() {

			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("id=") + 3, urls.length);
			var t = urls.substring(urls.indexOf("t=") + 2, urls.indexOf("t=") + 3);
			if(t==1){
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
						payment.fn.dataFill(list);
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});}
			if(t==2){
			$.ajax({
				type: 'GET',
				url: config.host + "/course/livedetail",
				data: {
					vid: id,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						payment.fn.dataFill2(list);
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});}

		},


		dataFill: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};

				var html = template('Payment', data);
				document.getElementById('pay').innerHTML = html;
			}
		},
		dataFill2: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};

				var html = template('Payment2', data);
				document.getElementById('pay').innerHTML = html;
			}
		},


		cordavaDataGet: function() {
			payment.dataInit();
		},
		
		buy:function(){
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("id=") + 3, urls.indexOf("&title"));
			var t = urls.substring(urls.indexOf("t=") + 2, urls.indexOf("t=") + 3);
			if(t==1){
			$.ajax({
				type:"get",
				url:config.host+"/course/create",
				data:{
					token:localStorage.getItem('token'),
					courseid:id,
				},
				dataType:"jsonp",
				success:function(data){
						var now = new Date();
                					var year = now.getFullYear();
              					var month =(now.getMonth() + 1).toString();
                					var day = (now.getDate()).toString();
                					if (month.length == 1) {
                					    month = "0" + month;
                					}
                					if (day.length == 1) {
                					    day = "0" + day;
                					}
                					var dateTime = year + month +  day;
						var rd = Math.floor(10000+Math.random()*(89999));
						var str = "";
						str += dateTime;
						str += "1";
						str += rd;
						
						if(confirm(str)){
							document.write(str+ courseid );
						}
					

					 
						
											
				},
				error:function(){
					alert('网络异常');
				}
			});

			}
			if(t==2){
			$.ajax({
				type:"get",
				url:config.host+"/course/createlive",
				data:{
					token:localStorage.getItem('token'),
					vid:id,
				},
				dataType:"jsonp",
				success:function(data){
														
						var now = new Date();
                					var year = now.getFullYear();
              					var month =(now.getMonth() + 1).toString();
                					var day = (now.getDate()).toString();
                					if (month.length == 1) {
                					    month = "0" + month;
                					}
                					if (day.length == 1) {
                					    day = "0" + day;
                					}
                					var dateTime = year + month +  day;
						var rd = Math.floor(10000+Math.random()*(89999));
						var str = "生成订单号：";
						str += dateTime;
						str += "1";
						str += rd;
						str += "。点击确定进入付款页面。";
						if(confirm(str)){
							document.write(id);
							document.write(str);

						}						
									},
				error:function(){
					alert('网络异常');
				}
			});

			}
		}
	}
}
$(function($) {
	payment.fn.cordavaDataGet();
});