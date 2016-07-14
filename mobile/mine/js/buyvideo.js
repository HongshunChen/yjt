var buyvideo = {
	data: {},
	dataInit: function() {
		buyvideo.fn.initialize();
		buyvideo.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			buyvideo.fn.shipinList(1);
		},
		shipinList: function(no) {
			$.ajax({
				type: 'GET',
				url: config.host + "/video/mylist",
				data: {
					token: localStorage.getItem('token'),
					page: no,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					if (list.status == 1) {
						//成功操作
						buyvideo.fn.dataFill(list, no);
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
				console.log('daole');
				var html = template('buyvideoList', data);
				document.getElementById('buyvideo_list').innerHTML = html;
				buyvideo.fn.ran(list.data.data.length);
				localStorage.setItem('page', list.data.last_page);
				buyvideo.fn.totalPage(list.data.last_page,no);
			}
		},
		totalPage: function(pages,no) {
			var pageCount = pages;
			if (pageCount > 5) {
				buyvideo.fn.page_icon(1, 5, no);
			} else {
				buyvideo.fn.page_icon(1, pageCount, no);
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

		tagFill: function() {
			var data = {
				user_name: '存放名称',
				ChaBuDaoXinXi: '查不到信息',
			};
			var tem = template('page', data);
			document.getElementById('page').innerHTML = tem;
		},
		initialize: function() {
			buyvideo.fn.tagFill();
		},
		cordavaDataGet: function() {
			buyvideo.dataInit();
			buyvideo.eventBind();

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
	buyvideo.fn.cordavaDataGet();
});