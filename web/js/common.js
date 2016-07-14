var token=localStorage.getItem('token');
if(token !=null){
	$('.you').load('../head.html');
	window.onload = function() {
	var a = JSON.parse(localStorage.getItem('userInfo')).nickname;
	$('#username').html(a);
}
}else{
	$('.you').load('../head2.html');
}


$('.zuihou').load('../foot.html');



