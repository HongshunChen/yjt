var anlifenxi = {
	data: {},
	dataInit: function() {
		$tokened=localStorage.getItem('token');
		if($tokened==null)
		{
			window.location.href="../login_register/deng.html";
		}
		anlifenxi.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			var urls = window.location.href;
			var type = urls.substring(urls.indexOf("=") + 1, urls.length);
			//			if (type == 4) { //简答题
			//			} else if (type == 5) { //辨析题
			//
			//			} else if (type == 6) { //策论文
			//			} else if (type == 7) { //案例分析
			//
			//			} else if (type == 8) { //公文写作
			//
			//			}
			$.ajax({
				type: 'GET',
				url: config.host + "/exam/create",
				data: {
					token: localStorage.getItem('token'),
					keytype: 1,
					questid: type,
					areaname: '全国',
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					if (list.status == 1) {
						localStorage.setItem('paper_id', list.data.paper_id);
						//						试卷类型
						localStorage.setItem('keytype', list.data.keytype);
						//						试题类型
						localStorage.setItem('questid', list.data.questid);
						anlifenxi.fn.getOne(1);
					} else {
						//alert(list.data);
					}
				},
				error: function(xhr, type) {

					console.log("请求失败");
					//alert('网络异常');
				}
			});
		},
		getOne: function(no) {
			$.ajax({
				type: "get",
				url: config.host + "/exam/getOne",
				data: {
					token: localStorage.getItem('token'),
					paper_id: localStorage.getItem('paper_id'), //试卷主键id
					question_no: no,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('shiti_id', data.data.id);                                                
						anlifenxi.fn.dataFill(data);
					} else {
						//alert(data.data);
					}
				},
				error: function() {
					//alert("网络异常");
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					list: list,
					questid: localStorage.getItem('questid'),
					no: list.data.next - 1,
				};
				var html = template('anLi', data);
				document.getElementById('anli').innerHTML = config.toHtml(html);
				var html = template('logo_', data);
				document.getElementById('logo').innerHTML = config.toHtml(html);
			}
		},

		cordavaDataGet: function() {
			anlifenxi.dataInit();
			anlifenxi.eventBind();

		},
		//下一题
		next: function(no) {
			anlifenxi.fn.getOne(no);
		},
		prev: function(no) {
			anlifenxi.fn.getOne(no);
		},
		//		付费批改
		pigai: function(id) {
			var img = document.getElementById('image-wrap').innerHTML; //图片
			var texts = document.getElementById('text-wrap').value; //文本内容
			var answer="";
			var types="";
			if(img!=""||texts!=""){					
				if(img!=""){
					var ttt=$("#image-wrap img");
					var t=ttt.length-1;
					var base_img=ttt[t].src;
					answer=encodeURIComponent(base_img);	
					types=2;
				}else{
					answer=texts;
					types=1;
				}
					$.ajax({
					type: "post",
					url: config.host + "/exam/submitOne",  
					data: {
						token: localStorage.getItem('token'),
						paper_question_id: id,
						answertype: types,
						answered: answer,
					},
//					dataType: "jsonp",
					success: function(data) {
						if (data.status == 1) {
							alert('提交成功');
						} else {
							alert(data.data);
						}
					},
					error: function() {
						//alert('网络异常');
					}
				});
			
			}else{
				alert('答案不能为空');
			}

		},
	}
}
$(function($) {
	anlifenxi.fn.cordavaDataGet();
});