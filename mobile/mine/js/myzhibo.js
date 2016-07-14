var myzhibo = {
	data: {},
	dataInit: function() {

		myzhibo.fn.list_init();
	},

	fn: {
		list_init: function() {
			myzhibo.fn.zhiboList(1);
		},

		zhiboList: function(no) {
			$.ajax({
				type: 'GET',
				url: config.host + "/video/mylivelist",
				data: {
					token: localStorage.getItem('token'),
					page: no,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						myzhibo.fn.dataFill(list, no);
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});
		},
		dataFill: function(list, no) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
					files: config.files,
				};
				var html = template('quanbushiPin', data);
				document.getElementById('quanbushi_pin').innerHTML = html;
				localStorage.setItem('page', list.data.last_page);
				myzhibo.fn.ran(list.data.data.length);
				myzhibo.fn.totalPage(list.data.last_page, no);
			}
		},
		totalPage: function(pages, no) {
			var pageCount = pages;
			if (pageCount > 5) {
				myzhibo.fn.page_icon(1, 5, no);
			} else {
				myzhibo.fn.page_icon(1, pageCount, no);
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

		cordavaDataGet: function() {
			myzhibo.dataInit();
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
	myzhibo.fn.cordavaDataGet();
});