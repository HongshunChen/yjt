var zuoyepigai = {
	data: {},
	dataInit: function() {
		zuoyepigai.fn.list_init();
	},
	fn: {
		list_init: function() {

			zuoyepigai.fn.zuoyeList(1);
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

						zuoyepigai.fn.dataFill(list, no);
					} else {

						window.location.href = "../login_register/deng.html";

						//$.alert(list.data);
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
				var html = template('zuoyepiGai', data);
				document.getElementById('zuoyepi_gai').innerHTML = html;
				zuoyepigai.fn.totalPage(list.data.last_page,no);
			}
		},
		totalPage: function(pages, no) {
			var pageCount = pages;
			if (pageCount > 5) {
				zuoyepigai.fn.page_icon(1, pageCount, no);
			} else {
				zuoyepigai.fn.page_icon(1, pageCount, no);
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
			zuoyepigai.dataInit();
		},
	}
}
$(function($) {
	zuoyepigai.fn.cordavaDataGet();
});