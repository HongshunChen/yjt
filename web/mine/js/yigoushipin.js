var yigoushipin = {
	data: {},
	dataInit: function() {
		yigoushipin.fn.list_init();
	},
	fn: {
		list_init: function() {
			yigoushipin.fn.shipinList(1);
		},
		shipinList:function(no){
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
						yigoushipin.fn.dataFill(list,no);
					} else {
						//alert(list.data);
						window.location.href="../login_register/deng.html";
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
					files:config.files,
				};
				var html = template('yigoushiPin', data);
				document.getElementById('yigoushi_pin').innerHTML = html;
				localStorage.setItem('page',list.data.last_page);
				yigoushipin.fn.totalPage(list.data.last_page,no);
			}
		},
		cordavaDataGet: function() {
			yigoushipin.dataInit();
		},
		totalPage: function(pages,no) {
			var pageCount = pages;
			if (pageCount > 5) {
				yigoushipin.fn.page_icon(1, 5, no);
			} else {
				yigoushipin.fn.page_icon(1, pageCount, no);
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
		//缓存记录
		jilu:function(no){
			$.ajax({
				type:"get",
				url:config.host+"/course/createlib",
				data:{
					token: localStorage.getItem('token'),
					videoid:no
				},
				dataType:"jsonp",
				success:function(data){
					if(data.status==1){
						alert("缓存成功");
					}else{
						alert(data.data);
					}
				},
				error:function(){
					alert("网络异常");
				}
			});
		},
	}
}
$(function($) {
	yigoushipin.fn.cordavaDataGet();
});