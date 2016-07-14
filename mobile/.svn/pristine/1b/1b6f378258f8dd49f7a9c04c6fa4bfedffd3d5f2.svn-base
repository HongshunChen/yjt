var danxuanti = {
	data: {
		paper: null
	},
	dataInit: function() {
		danxuanti.fn.init();
		danxuanti.fn.questionOne();
	},
	fn: {
		init: function () {
			danxuanti.data.paper = localStorageGet('paper');
		},
		//获取单条试题
		questionOne: function() {
			var _url = config.host + '/exam/getOne';
			//var paper = localStorageGet('paper');
			var _data = {
				paper_id: danxuanti.data.paper.paper_id,
				question_no: danxuanti.data.paper.current_question_no
			}

			
			http_request(_url, _data, function (data) {
				danxuanti.fn.dataFill(data);
			})

		},
		dataFill: function(data) {
			if (data) {
				data.questionSelectArr = createSelectArr(data.questionselectnumber);
				data.total_count = danxuanti.data.paper.total_count;
				data.paper_type = config.questionType[danxuanti.data.paper.paper_type];
				data.questiontype_name = config.questionType[data.questiontype];
				var data = {
					data: data,
				};
				var html = template('danXuan', data);
				document.getElementById('dan_xuan').innerHTML = html;

				if(!danxuanti.data.paper.is_timer) {
					danxuanti.data.paper.is_timer = 1;
					my_timer(0);
				}
			}
		},
		//下一题
		next: function(next) {
			if(next == 0) {
				alert('没有下一题了');
			} else {
				danxuanti.data.paper.current_question_no = next;
				localStorageSet('paper', danxuanti.data.paper);
				danxuanti.fn.questionOne(next);
			}
		},
		//上一题
		prev: function(prev) {
			if (prev == 0) {
				alert('没有上一题了');
			} else {
				danxuanti.data.paper.current_question_no = prev;
				localStorageSet('paper', danxuanti.data.paper);
				danxuanti.fn.questionOne(prev);
			}
		},
		//获取的答案
		obtainOptions: function() {
			var optionsBox = $('#question_options .question_option');
			var answered = '';
			var _len = optionsBox.length;
			for (var _i = 0; _i<_len; _i++) {
				var isChecked = optionsBox[_i].checked;
				if(isChecked) {
					var _checked_no = optionsBox[_i].getAttribute("data-no");
					answered += config.selectArr[_checked_no];
				}
			}
			return answered;
		},
		//提交答案
		submit_answer: function(no, id, answertype, answered) {

			if (answertype == 1) {
				answered = danxuanti.fn.obtainOptions();
			}

			var _url = config.host + '/exam/submitOne';
			var _data = {
				paper_question_id: id,
				answertype: answertype,
				answered: answered
			}
			http_request(_url, _data, function (data) {
				//暂不做任何处理
			})
		},
		//交卷
		paperSubmit: function(paper_id) {
			var url = config.host + '/exam/assignment';
			var data = {
				paper_id: paper_id
			};
			http_request(url, data, function (data) {
				var paper = localStorageGet('paper');
				var paper_type = paper.paper_type;
				if(paper_type == '0') {
					window.location.href='../quanzhen/cuotijiexi_quanzhen.html';
				} else {
					window.location.href='./pinggubaogao.html';
				}
			})
		},
	}
}
$(function() {
	danxuanti.dataInit();
});