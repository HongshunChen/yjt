var zhibo = {
	data: {},
	dataInit: function() {
		zhibo.fn.list_init();
	},
	fn: {
		list_init: function() {
			zhibo.fn.zhobo_list(1);
			//初始化左边的类型
			$.ajax({
				type: "get",
				url: config.host + "course/type",
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('total_type', data.data.length);
						zhibo.fn.typeFill(data);
					} else {
						Zepto.alert(data.data);
					}
				},
				error: function() {
					Zepto.alert("网络异常");
				}
			});
		},

		zhobo_list: function(no) {
			$.ajax({
				type: 'GET',
				url: config.host + "/course/livelist",
				data: {
					c: "",
					n: "",
					k: "",
					page: no,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					if (list.status == 1) {
						localStorage.setItem('num0', "");
						localStorage.setItem('num1', "");
						localStorage.setItem('num2', "");
						localStorage.setItem('pageto', 1);
						zhibo.fn.dataFill(list);
						localStorage.setItem('page', list.data.last_page);
						zhibo.fn.totalPage(list.data.last_page, no);
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
		left_handle: function(no) {
			var no1 = localStorage.getItem('num0');
			var no2 = localStorage.getItem('num1');
			var no3 = localStorage.getItem('num2');
			var no11 = no1.replace(/(\s*$)/g, "");
			if (no11 == "全部") {
				no11 = "";
			}
			var no22 = no2.replace(/(\s*$)/g, "");
			if (no22 == "全部") {
				no22 = "";
			}
			var no33 = no3.replace(/(\s*$)/g, "");
			if (no33 == "全部") {
				no33 = "";
			}
			$.ajax({
				type: 'GET',
				url: config.host + "/course/livelist",
				data: {
					page: no,
					c: no11,
					n: no22,
					k: no33,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					if (list.status == 1) {
						zhibo.fn.dataFill(list);
						localStorage.setItem('page', list.data.last_page);
						zhibo.fn.totalPage(list.data.last_page, no);
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
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
				};
				for (var i = 0; i < list.data.data.length; i++) {
					list.data.data[i].createtime = zhibo.fn.forData(list.data.data[i].createtime);
					list.data.data[i].endtime = zhibo.fn.forData(list.data.data[i].endtime);
				}
				var html = template('zhiboList', data);
				document.getElementById('zhibo_list').innerHTML = html;
				zhibo.fn.ran(list.data.data.length);

			}
		},

		initialize: function() {
			zhibo.fn.tagFill();
		},
		cordavaDataGet: function() {
			zhibo.dataInit();

		},
		totalPage: function(pages, no) {
			var pageCount = pages;
			if (pageCount > 5) {
				zhibo.fn.page_icon(1, 5, no);
			} else {
				zhibo.fn.page_icon(1, pageCount, no);
			}
		},
		//根据当前选中页生成页面点击按钮
		page_icon: function(page, count, eq) {
			var t = eq - 1;
			var ul_html = "";
			for (var i = page; i <= count; i++) {
				ul_html += "<li onclick='one(" + i + ")'>" + i + "</li>";
			}
			$("#pageGro ul").html(ul_html);
			$("#pageGro ul li").eq(t).addClass("on");
		},

		forData: function(timer) {
			var date = new Date(timer);
			Y = date.getFullYear() + '.';
			M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '.';
			D = date.getDate() + ' ';
			h = date.getHours() + ':';
			m = date.getMinutes() + ':';
			s = date.getSeconds();
			return Y + M + D;
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

		xuan: function(obj) {
			var type_length = localStorage.getItem('total_type');
			var leftid = [];
			for (var i = 0; i < type_length; i++) {
				leftid[i] = 'left' + i;
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
			localStorage.setItem('num0', num[0]);
			localStorage.setItem('num1', num[1]);
			localStorage.setItem('num2', num[2]);
			localStorage.setItem('pageto', 1);
			zhibo.fn.left_handle(1);
		},
	}
}
$(function($) {
	zhibo.fn.cordavaDataGet();
});