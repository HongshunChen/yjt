var panduanti = {
	data: {},
	dataInit: function() {
		panduanti.fn.list_init();
	},
	fn: {
		list_init: function() {
			//生成试卷
			$.ajax({
				type: 'GET',
				url: config.host + "/exam/createNew",
				data: {
					token: localStorage.getItem('token'),
					questid: "3",
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						console.log("请求成功");
						localStorage.setItem('paperid', data.data.paper_id);
						console.log(localStorage.getItem('paperid'));
						//获取单条试题
						panduanti.fn.questionOne(1)

					} else {
						alert(data.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					alert('网络异常');
				}
			});
		},
		//获取单条试题
		questionOne: function(no) {
			$.ajax({
				type: 'GET',
				url: config.host + '/exam/getOne',
				data: {
					token: localStorage.getItem('token'),
					paper_id: localStorage.getItem('paperid'),
					question_no: no,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						localStorage.setItem('questionNo', no);
						localStorage.setItem('questionid', data.data.id);
						panduanti.fn.dataFill(data, no);
					} else {
						alert(data.data);
					}
				},
				error: function(xhr, type) {
					alert('网络异常');
				}
			});
		},
		dataFill: function(list, no) {
			if (list) {
				var data = {
					total: list.length,
					list: list,
				};
				list.data.shu = no;
				var html = template('panDuan', list.data);
				document.getElementById('pan_duan').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			panduanti.dataInit();
			

		},
		//		提交答案
		submit_answer: function(no, id, o_W) {
			//选中的答案
			var answer = panduanti.fn.ones();
			$.ajax({
				type: "get",
				url: config.host + "/exam/submitOne",
				data: {
					token: localStorage.getItem('token'),
					paper_question_id: id, //试题id
					answered: answer,
				},
				dataType: 'jsonp',
				success: function(data) {
					//获取下一个题目
					if (data.status == 1) {
						if (o_W == 1) {
							var shu = no + 1;
							panduanti.fn.questionOne(shu);
						} else if (o_W == 2) {
							var shu = no - 1;
							panduanti.fn.questionOne(shu);
						} else if (o_W == 3) {
							window.location.href = 'fenxibaogao.html';
						}
					} else {
						alert(data.data);
					}
				},
				error: function(xhr, type) {
					alert('网络异常');
				}
			});

		},
		//下一题
		next: function(no, id) {
			panduanti.fn.submit_answer(no, id, 1);
		},
		//上一题
		one_more: function(no) {
			panduanti.fn.submit_answer(no, id, 2);
		},

		//继续答题
		carry_over: function() {
			$('.theme-popover-mask')[0].style.display = "none";
			$('.theme-popover')[0].style.display = 'none';
		},
		//获取的答案
		ones: function() {
			var aSpan = $('#pan_one li');
			for (var i = 0; i < aSpan.length; i++) {
				if (aSpan[i].className == 'hit1') {
					var str = aSpan[i].innerText;
					return str.replace(/[\r\n]/g,  '');
				}
			}
		},
		//交卷
		papers: function() {
			var no = localStorage.getItem('questionNo');
			var id = localStorage.getItem('questionid');
			panduanti.fn.submit_answer(no, id, 3);
		},
	}
}
$(function($) {
	panduanti.fn.cordavaDataGet();
});