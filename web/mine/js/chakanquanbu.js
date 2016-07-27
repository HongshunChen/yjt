var chakanquanbu = {
	data: {},
	dataInit: function() {

		chakanquanbu.fn.list_init();
	},

	fn: {
		list_init: function() {
			chakanquanbu.fn.zhiboList(1);
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
						chakanquanbu.fn.dataFill(list);
						chakanquanbu.fn.totalPage(list.data.last_page, no);
					} else {
						window.location.href = "../login_register/deng.html";
						//alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					alert('网络异常');
				}
			});
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
					files: config.files,
				};
				var html = template('quanbushiPin', data);
				document.getElementById('quanbushi_pin').innerHTML = html;

			}
		},
		totalPage: function(pages, no) {
			var pageCount = pages;
			if (pageCount > 5) {
				chakanquanbu.fn.page_icon(1, pageCount, no);
			} else {
				chakanquanbu.fn.page_icon(1, pageCount, no);
			}
		},
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
			chakanquanbu.dataInit();
		},
	}
}
$(function($) {
	chakanquanbu.fn.cordavaDataGet();
});