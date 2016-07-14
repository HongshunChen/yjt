var huancunshipin = {
	data: {},
	dataInit: function() {
		huancunshipin.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {
			huancunshipin.fn.huancun(1);
		},
		huancun:function(no){
			$.ajax({
					type: 'GET',
					url: config.host + "/video/mylib",
					data: {
						token:localStorage.getItem('token'),
						page:no,
					},
					dataType: "jsonp",
					success: function(list) {
						console.log("请求成功");
						
						if (list.status == 1) {
							//成功操作
							huancunshipin.fn.dataFill(list,no);
						} else {
                                                        alert('该课程未找到，或已失效！');
                                                        history.go(-1);
							//window.location.href="../login_register/deng.html";
							//alert(list.data);
						}
					},
					error: function(xhr, type) {
						console.log("请求失败");
						alert('网络异常');
					}
				});
		},
		dataFill: function(list,no) {
			if (list) {
				var data = {
					total: list.data.data.length,
					list: list,
				};
				var html = template('huancunshiPin', data);
				document.getElementById('huancunshi_pin').innerHTML = html;
				localStorage.setItem('page',list.data.last_page);
				huancunshipin.fn.totalPage(list.data.last_page,no);
			}
		},
		totalPage: function(pages,no) {
			var pageCount = pages;
			if (pageCount > 5) {
			huancunshipin.fn.page_icon(1, 5, no);
			} else {
				huancunshipin.fn.page_icon(1, pageCount, no);
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
			huancunshipin.dataInit();
		},
	}
}
$(function($) {
	huancunshipin.fn.cordavaDataGet();
});