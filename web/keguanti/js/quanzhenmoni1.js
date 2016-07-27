var quanzhenmoni = {
	data: {},
	dataInit: function() {

		$tokened=localStorage.getItem('token');
		if($tokened==null)
		{
			window.location.href="../login_register/deng.html";
		}

		quanzhenmoni.fn.list_init();
	},

	fn: {
		list_init: function() {
			var urls = window.location.href;
			var type = urls.substring(urls.indexOf("=") + 1, urls.length);
			var questionid = "";
			var keyType = "";
			
			if (type == 't1') {
				//单选题
				keyType = 1;
				questionid = 1;
			} else if (type == 't2') {
				//多选题
				keyType = 1;
				questionid = 2;
			} else if (type == 't3') { 
				//判断题
				keyType = 1;
				questionid = 3;
			} else {
				//全真模拟
				keyType = 2;
				questionid = 0;
				var address=quanzhenmoni.fn.getAddress().areaname;
				
			}
			//根据条件生成试卷
			$.ajax({
				type: "get",
				url: config.host + "/exam/create",
				data: {
					token: localStorage.getItem('token'),
					keytype: keyType,
					questid: questionid,
					areaname: address, //模拟的地区参数
				},
				dataType: 'jsonp',
				success: function(data) {
					if (data.status == 1) {
						//试卷id
						localStorage.setItem('paper_id', data.data.paper_id);
						//试卷类型
						localStorage.setItem('keytype', data.data.keytype);
						//试题类型
						localStorage.setItem('questid', data.data.questid);
						//题数
						localStorage.setItem('total_count', data.data.total_count);
						//分数
						localStorage.setItem('total_score', data.data.total_score);
						//获取显示的试题
						if (data.data.keytype == 1) { //客观题只显示一条信息
							quanzhenmoni.fn.getOne(1);
						} else {
							//获取全真模拟整套试题
							$.ajax({
								type: "get",
								url: config.host + "/exam/simulate",
								data: {
									token: localStorage.getItem('token'),
									paper_id: localStorage.getItem('paper_id'), //试卷主键id
								},
								dataType: "jsonp",
								success: function(data) {
									if (data.status == 1) {
										quanzhenmoni.fn.quanzhenFill(data);
									} else {
										//alert(data.data);
									}
								},
								error: function() {
									//alert('网络异常');
								}
							})
						}
					} else {
						//alert(data.data);
					}

				},
				error: function() {
					//alert('网络异常');
				}
			});
		},
		getAddress:function(){
				var url = window.location.search; //获取url中"?"符后的字串
			
			var theRequest = new Object();   
       if (url.indexOf("?") != -1) {   
          var str = url.substr(1);   
          strs = str.split("&");   
          for(var i = 0; i < strs.length; i ++) {   
              //就是这句的问题
             theRequest[strs[i].split("=")[0]]=decodeURI(strs[i].split("=")[1]); 
             //之前用了unescape()
             //才会出现乱码  
          }   
       }   
       return theRequest;
			
		},
		//获取单条试题
		getOne: function(no) {
			$.ajax({
				type: "get",
				url: config.host + "/exam/getOne",
				data: {
					token: localStorage.getItem('token'),
					paper_id: localStorage.getItem('paper_id'), //试卷主键id
					question_no: no,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						quanzhenmoni.fn.dataFill(no, data);
					} else {
						//alert(data.data);
					}
				},
				error: function() {
					//alert("网络异常");
				}
			});
		},

		quanzhenFill: function(list) {
			if (list) {
				var data = {
					list: list,
				};
				list.data.radioT = list.data.radio.list.length;
				list.data.multipleT = list.data.multiple.list.length;
				list.data.judgementT = list.data.judgement.list.length;

				var html = template('Top', data);
				document.getElementById('top').innerHTML = html;
				var html = template('quanDan', list.data);
				document.getElementById('quan_dan').innerHTML = html;
			}
		},
		//单击之后提交答案
		onclick_answer: function(id, answer) {
			$.ajax({
				type: "get",
				url: config.host + "/exam/submitOne",
				data: {
					token: localStorage.getItem('token'),
					paper_question_id: id,
					answertype: 1,
					answered: answer,
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						
						//alert('提交成功');
					} else {
						//alert(data.data);
					}
				},
				error: function() {
					//alert('网络异常');
				}
			});
		},
		//点击上一题或下一题
		submit_answer: function(id, no) {
			quanzhenmoni.fn.getOne(no);
		},

		//交卷
		assignment: function() {
			$.ajax({
				type: "get",
				url: config.host + "/exam/assignment",
				data: {
					token: localStorage.getItem('token'),
					paper_id: localStorage.getItem('paper_id'),
				},
				dataType: "jsonp",
				success: function(data) {
					if (data.status == 1) {
						window.location.href = 'fenxibaogao.html';
					} else {
						//alert(data.data);
					}
				},
				error: function() {
					//alert('网络异常');
				}
			})
		},
		//客观题数据填充
		dataFill: function(no, list) {
			var questid = localStorage.getItem('questid');
			if (list) {
				var data = {
					list: list,
					//试卷类型
					keytype: localStorage.getItem('keytype'),
					//试题类型
					questid: questid,
					//题数
					total_content: localStorage.getItem('total_count'),
					//分数
					total_score: localStorage.getItem('total_score'),
					no: no,
				};
				var html = template('All', data);
				document.getElementById('all').innerHTML = html;
				var html = template('Top', data);
				document.getElementById('top').innerHTML = html;
				//1、id 2、问题类型 3、选项个数
				quanzhenmoni.fn.zimu_dan(list.data.id, list.data.questiontype, list.data.questionselectnumber);
				//如果答过该题就会显示答案，一般用在上一题
				var name = list.data.answered;
				if (name != "") {
					quanzhenmoni.fn.getOption(name);
				}
			}
		},

		cordavaDataGet: function() {
			quanzhenmoni.dataInit();
		},
		//循环显示选项
		zimu_dan: function(id, type, shu) {
			//多选      <li onclick="duo_more(this)" value='D'><a>D</a></li>
			//判断          <li onclick="dan(this)" value="B"><a>错</a></li>
			//	<li onclick="dan(this)" value="A"><a>对</a></li>
			var a = 65;
			var at = '';
			if (type == '3') {
				var A = 'A';
				var B = 'B';
				var ot1 = '"' + A + '"';
				var ot2 = '"' + B + '"';
				at = "<li id='A' onclick='dan(this),quanzhenmoni.fn.onclick_answer(" + id + "," + ot1 + ")'><a>对</a></li>" +
					"<li id='B' onclick='dan(this),quanzhenmoni.fn.onclick_answer(" + id + "," + ot2 + ")'><a>错</a></li>";
			} else {
				for (var i = 65; i < 91; i++) {
					if (i < a + shu) {
						var o = String.fromCharCode(i);
						var ot = '"' + o + '"';
						if (type == '1') {
							at += "<li id=" + o + " onclick='dan(this),quanzhenmoni.fn.onclick_answer(" + id + "," + ot + ")'><a>" + o + "</a></li>";
						} else if (type == '2') {
							at += "<li id=" + o + " onclick='duo_more(this),quanzhenmoni.fn.onclick_answer(" + id + "," + ot + ")'><a>" + o + "</a></li>";
						}
					}
				}
			}
			document.getElementById('dan_one').innerHTML = at;
		},
		//获取答案
		//		getAnswer: function() {
		//			var aSpan = $('#dan_one li');
		//			var answers = '';
		//			for (var i = 0; i < aSpan.length; i++) {
		//				if (aSpan[i].className == 'hit1') {
		//					var str = aSpan[i].id;
		//					var a = str.replace(/[\r\n]/g,  '');
		//					answers += a;
		//				}
		//			}
		//			return answers;
		//		},
		//	显示上一题的答案
		getOption:function(name) {
			var ch = name.replace(/(.)(?=[^$])/g, "$1,").split(",");
			var aSpan = $('#dan_one li');
			var answers = '';
			for (var i = 0; i < aSpan.length; i++) {
				for (var t = 0; t < ch.length; t++) {
					if (aSpan[i].id == ch[t]) {
						aSpan[i].className = "hit1";
					}
				}
			}
		},

		//继续答题
		carry_over: function() {
			$('.theme-popover-mask')[0].style.display = "none";
			$('.theme-popover')[0].style.display = 'none';
		},

		//交卷
		papers: function() {
			var keytype = localStorage.getItem('keytype');
			if (keytype == 2) {
				//if($.confirm('是否确认交卷？')) {
					quanzhenmoni.fn.jianda_sub(keytype);

				//}
							} else {
				quanzhenmoni.fn.assignment();
			}
		},
		//如果是模拟题提交客观题
		jianda_sub: function(keytype) {
			var id = document.getElementById('subject').innerHTML;
			var img = document.getElementById('image-wrap').innerHTML; //图片
			var texts = document.getElementById('text-wrap').value; //文本内容
			var answer = "";
			var types = "";
			if (img != "" || texts != "") {
				if (img != "") {
					var ttt = $("#image-wrap img");
					var t = ttt.length - 1;
					var base_img = ttt[t].src;
					answer = base_img;
					types = 2;
				} else {
					answer = texts;
					types = 1;
				}
				$.ajax({
					type: "post",
					url: config.host + "/exam/submitOne",
					data: {
						token: localStorage.getItem('token'),
						paper_question_id: id,
						answertype: types,
						answered: answer,
					},
					
					success: function(data) {
						if (data.status == 1) {
							alert('提交成功');
							quanzhenmoni.fn.assignment();
						} else {
							//alert(data.data);
						}
					},
					error: function() {
						//alert('网络异常');
					}
				});
			}else{
				quanzhenmoni.fn.assignment();
			}
		},
	}
}
$(function($) {
	quanzhenmoni.fn.cordavaDataGet();
});

