var lianxizhongxin = {
	data: {},
	dataInit: function() {
		lianxizhongxin.fn.list_init();
	},
	fn: {
		list_init: function() {

			lianxizhongxin.fn.zuoyeList(1);
		},

		zuoyeList: function(no) {
			$.ajax({
				type: 'GET',
				url: config.host + "/video/mysublist",
				data: {
					token: localStorage.getItem('token'),
					page: no,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");
					if (list.status == 1) {
						//登录成功操作
						lianxizhongxin.fn.dataFill(list,no);
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
		dataFill: function(list,no) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
					files: config.files,
				};
				var html = template('lianxizhongxin', data);
				document.getElementById('zuoyepi_gai').innerHTML = html;
				localStorage.setItem('page', list.data.last_page);
				lianxizhongxin.fn.totalPage(list.data.last_page,no);
			}
		},
		
		totalPage: function(pages,no) {
			var pageCount = pages;
			if (pageCount > 5) {
				lianxizhongxin.fn.page_icon(1, 5, no);
			} else {
				lianxizhongxin.fn.page_icon(1, pageCount, no);
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


		cordavaDataGet: function() {
			lianxizhongxin.dataInit();
		},
	}
}
Zepto(function($) {
	lianxizhongxin.fn.cordavaDataGet();
});