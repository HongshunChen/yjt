function dan(shu) {
	$(shu).addClass('hit1').siblings().removeClass('hit1');
	$('.panes>div:eq(' + $(shu).index() + ')').show().siblings().hide();

}

//function xuan(shu) {
//	$(shu).addClass('hit').siblings().removeClass('hit');
//	$('.panes>div:eq(' + $(shu).index() + ')').show().siblings().hide();
//
//}

function change_one(obj) {
	var activeImage = $(obj).children('img.active');
	activeImage.removeClass('active');
	if (activeImage.next().length > 0) {
		activeImage.next().addClass('active');
	} else {
		$(obj).children('img:first-child').addClass('active');
	}
	return false;
}
function change_one1(obj) {
	$(obj).addClass('active').siblings().removeClass('active');
//	var activeImage = $(obj).children('img.active');
//	activeImage.removeClass('active');
//	if (activeImage.next().length > 0) {
//		activeImage.next().addClass('active');
//	} else {
//		$(obj).children('img:first-child').addClass('active');
//	}
//	return false;
}
function duo_more(obj) {
	var activeImage = $(obj);
	activeImage.removeClass('hit1');
	if (activeImage.length > 0) {
		activeImage.addClass('hit1');
	}
	return false;
}
jQuery(document).ready(function($) {
	$('.theme-login').click(function() {
		$('.theme-popover-mask').fadeIn(100);
		$('.theme-popover').slideDown(200);
	})
	$('.theme-poptit .close').click(function() {
		$('.theme-popover-mask').fadeOut(100);
		$('.theme-popover').slideUp(200);
	})
})

window.onload  =   function() {
	//全部加载完成！！ 
	$(".navmenu ul li:has(ul)").hover(function() {
			$(this).find("li").children("a").css({
				color: "#fff"
			});
			if ($(this).find("li").length > 0) {
				$(this).children("ul").stop(true, true).slideDown(100)
			}
		},
		function() {
			$(this).find("li").children("a").css({
				color: "#fff"
			});
			$(this).children("ul").stop(true, true).slideUp("fast")
		});
}


function collect(id){
	$.ajax({
		type:"get",
		url:config.host+"/collect/update",
		data:{
			token:localStorage.getItem('token'),
			questionid:id,
		},
		dataType:"jsonp",
		success:function(data){
			if(data.status==1){
				alert(data.data.tips);
			}else{
				alert(data.data);
			}
		},
		error:function(){
			alert('网络异常');
		}
	});
}

function del_collect(id,type){
        $.ajax({
		type:"get",
		url:config.host+"/collect/update",
		data:{
			token:localStorage.getItem('token'),
			questionid:id,
		},
		dataType:"jsonp",
		success:function(data){
			if(data.status==1 && data.data.tips==='取消收藏'){
                            window.location.href='./collectList.html?type='+type;
				//alert(data.data.tips);
			}else{
				
			}
		},
		error:function(){
			alert('网络异常');
		}
	});
	//alert("删除");
}
