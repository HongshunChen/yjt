var tehuikecheng = {
	data: {},
	dataInit: function() {
		tehuikecheng.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
		//视频课程列表
			$.ajax({
				type: 'GET',
				url: config.host + "/course/list", //----视频课程的接口
				data: {
					page: 1,
					c: "",
					n: "",
					k: "",
				},
				dataType: "jsonp",
				success: function(list) { //----成功返回
					console.log("请求成功");
					if (list.status == 1) {
						localStorage.setItem('num0',"");
						localStorage.setItem('num1',"");
						localStorage.setItem('num2',"");
						localStorage.setItem('pageto',1);
						//登录成功操作----成功返回数据
						tehuikecheng.fn.dataFill(list); //---调用的方法
//						tehuikecheng.fn.ran(list.data.data.length);
						tehuikecheng.fn.totalPage(list.data.last_page,1);

					} else {
						alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					alert('网络异常');
				}
			});
				
					//初始化左边的类型
			$.ajax({
				type: "get",
				url: config.host + "course/type",
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('total_type',data.data.length);
						tehuikecheng.fn.typeFill(data);
					} else {
						alert(data.data);
					}
				},
				error: function() {
					alert("网络异常");
				}
			});
		},
		typeFill: function(list) {
			if (list) {
				var data = {
					list: list,
				}
			}
			var html = template('Type', data);
			document.getElementById('type').innerHTML = html;

		},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
					files: config.files,
				};
				console.log(list.total);
				var html = template('tehuiList', data);
				document.getElementById('tehui_list').innerHTML = html;
			}
		},
			xuan:function(obj) {
			var type_length=localStorage.getItem('total_type');
			var leftid=[];
			for(var i=0;i<type_length;i++){
				leftid[i]='left'+i;
			}
			var Courseify1 = '';
			$(obj).addClass('hit').siblings().removeClass('hit');
			$('.panes>div:eq(' + $(obj).index() + ')').show().siblings().hide();
			for (var t = 0; t < type_length; t++) {
				var aSpan = $('#' + leftid[t] + ' li');
				for (var i = 0; i < aSpan.length; i++) {
					if (aSpan[i].className == 'hit') {
						Courseify1 += aSpan[i].innerText + ',';
					}
				}
			}
			var num = Courseify1.split(',');
			console.log(num[0]);
			console.log(num[1]);
			console.log(num[2]);
			localStorage.setItem('num0',num[0]);
			localStorage.setItem('num1',num[1]);
			localStorage.setItem('num2',num[2]);
			localStorage.setItem('pageto',1);
			tehuikecheng.fn.left_type();
		},
		cordavaDataGet: function() {
			tehuikecheng.dataInit();
			tehuikecheng.eventBind();

		},
		left_type: function() {
			var no1=localStorage.getItem('num0');
			var no2=localStorage.getItem('num1');
			var no3=localStorage.getItem('num2');
			var no11=no1.replace(/(\s*$)/g,"");
			if(no11=="全部"){
				no11="";
			}
			var no22=no2.replace(/(\s*$)/g,"");
			if(no22=="全部"){
				no22="";
			}
			var no33=no3.replace(/(\s*$)/g,"");
			if(no33=="全部"){
				no33="";
			}
			$.ajax({
				type: 'GET',
				url: config.host + "/course/list", //----视频课程的接口
				data: {
					page: localStorage.getItem('pageto'),
					c: no11,
					n: no22,
					k: no33,
				},
				dataType: "jsonp",
				success: function(list) { //----成功返回
					console.log("请求成功");
					if (list.status == 1) {
						//						登录成功操作----成功返回数据
						tehuikecheng.fn.dataFill(list); //---调用的方法
						tehuikecheng.fn.ran(list.data.data.length);
						localStorage.setItem('page',list.data.last_page);
						tehuikecheng.fn.totalPage(list.data.last_page,localStorage.getItem('pageto'));

					} else {
						alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					alert('网络异常');
				}
			});
		},
		totalPage: function(pages,no) {
			var pageCount = pages;
			if (pageCount > 5) {
				tehuikecheng.fn.page_icon(1, 5, no);
			} else {
				tehuikecheng.fn.page_icon(1, pageCount, no);
			}
		},
		page_icon: function(page, count, eq) {
			var t=eq-1;
			var ul_html = "";
			for (var i = page; i <= count; i++) {
				ul_html += "<li onclick='one(" + i + ")'>" + i + "</li>";
			}
			$("#pageGro ul").html(ul_html);
			$("#pageGro ul li").eq(t).addClass("on");
		},
		 ran: function(no) {
			for (var i = 0; i < no; i++) { 
				var  a, b;            
				b = parseInt(Math.random() * 99);            
				if (b !== a) {                
					a = b;            
				} else {                
					arguments.callee();            
				}
				document.getElementById('by' + i).innerText = b;
			}    
		},
		
	}
}
$(function($) {
	tehuikecheng.fn.cordavaDataGet();
});