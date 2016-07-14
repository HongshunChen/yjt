var zibei = {
	data: {},
	dataInit: function() {
		zibei.fn.list_init();
	},
	eventBind: function() {},
	fn: {
		list_init: function() {},
		dataFill: function() {},
		tagFill: function() {},
		initialize: function() {
			zibei.fn.tagFill();
		},
		cordavaDataGet: function() {
			zibei.dataInit();
			zibei.eventBind();
		},
		payment: function() {
			var question_type;
			var question;
			var answer_type;
			var answer;
			var t_qu = document.getElementById('text-wrap_qu').value;
			var i_qu = document.getElementById('image-wrap_qu').innerHTML;
			var an_text = document.getElementById('text-wrap').value;
			var an_img = document.getElementById('image-wrap').innerHTML;

			if (t_qu != "") {
				question_type = 1;
				question = t_qu;
			} else if (i_qu != "") {

				var ttt = $("#image-wrap_qu img");
				var t = ttt.length - 1;
				var base_img = ttt[t].src;
				question = base_img;

				question_type = 2;

			}
			if (an_text != "") {
				answer_type = 1;
				answer = an_text;
			} else if (an_img != "") {

				var ttt = $("#image-wrap img");
				var t = ttt.length - 1;
				var base_img = ttt[t].src;
				answer = base_img;

				answer_type = 2;

			}
			$.ajax({
				type: "post",
				url: config.host + "/self/upload",
				data: {
					token: localStorage.getItem('token'),
					question_type: question_type,
					question: question,
					answer_type: answer_type,
					answer: answer,
				},
//				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						alert("成功提交");
					} else {
						alert(data.data);
					}
				},
				error: function() {
					alert("网络异常");
				}
			});
		}
	}
}
$(function($) {
	zibei.fn.cordavaDataGet();
});