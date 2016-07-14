var shipinkecheng = {
	data: {},
	dataInit: function() {
		shipinkecheng.fn.list_init();
	},
	fn: {
		list_init: function() { //页面加载js的时候就会初始化这个方法，所以加载完页面的时候同时执行视频课程的列表方法
			//视频课程列表
			shipinkecheng.fn.shipin_list(1);
			//初始化左边的类型
			$.ajax({
				type: "get",
				url: config.host + "course/type",
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('total_type',data.data.length);
						shipinkecheng.fn.typeFill(data);
					} else {
						Zepto.alert(data.data);
					}
				},
				error: function() {
					Zepto.alert("网络异常");
				}
			});
		},
		shipin_list:function(no){
			$.ajax({
				type: 'GET',
				url: config.host + "/course/list", //----视频课程的接口
				data: {
					page: no,
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
						var a = list.data.data[0].coursename;
						shipinkecheng.fn.dataFill(list); //---调用的方法
						shipinkecheng.fn.ran(list.data.data.length);
						shipinkecheng.fn.totalPage(list.data.last_page,no);

					} else {
						Zepto.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					Zepto.alert('网络异常');
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
		cordavaDataGet: function() {
			shipinkecheng.dataInit();

		},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
					files: config.files,
				};

				var html = template('kechengList', data);
				//这个是模板<script type="text/html" id="kechengList">自动找到id
				document.getElementById('kecheng_list').innerHTML = html; //把这个html模板加载到 id是kecheng_list 的div中
				//<div class="youbian2" id="kecheng_list">  
			}
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
		totalPage: function(pages,no) {
			var pageCount = pages;
			if (pageCount > 5) {
			shipinkecheng.fn.page_icon(1, 5, no);
			} else {
				shipinkecheng.fn.page_icon(1, pageCount,no);
			}
		},
		
		//根据当前选中页生成页面点击按钮
		page_icon: function(page, count, eq) {
			var t=eq-1;
			var ul_html = "";
			for (var i = page; i <= count; i++) {
				ul_html += "<li onclick='one(" + i + ")'>" + i + "</li>";
			}
			$("#pageGro ul").html(ul_html);
			$("#pageGro ul li").eq(t).addClass("on");
		},

		left_type: function(no) {
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
					page: no,
					c: no11,
					n: no22,
					k: no33,
				},
				dataType: "jsonp",
				success: function(list) { //----成功返回
					console.log("请求成功");
					if (list.status == 1) {
						//						登录成功操作----成功返回数据
						shipinkecheng.fn.dataFill(list); //---调用的方法
						shipinkecheng.fn.ran(list.data.data.length);
						localStorage.setItem('page',list.data.last_page);
						shipinkecheng.fn.totalPage(list.data.last_page,no);

					} else {
						Zepto.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					Zepto.alert('网络异常');
				}
			});
		},
		by: function(id) {
			$.ajax({
				type: "get",
				url: config.host + "/course/create",
				data: {
					token: localStorage.getItem('token'),
					courseid: id,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						$.alert('购买成功');
					} else {
						Zepto.alert(data.data);
					}
				},
				error: function() {
					Zepto.alert('网络异常');
				}
			});
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
			shipinkecheng.fn.left_type(1);
		},

	}
}

$(function($) {
	shipinkecheng.fn.cordavaDataGet();
});