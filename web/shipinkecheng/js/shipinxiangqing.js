var shipinxiangqing = {
	data: {},
	dataInit: function() {
		shipinxiangqing.fn.list_init();
	},
	fn: {
		list_init: function() {
			var urls = window.location.href;
			var id = urls.substring(urls.indexOf("=") + 1, urls.length);
			shipinxiangqing.fn.teacher_list();
                        shipinxiangqing.fn.comment_list(id);
			$.ajax({
				type: 'GET',
				url: config.host + "/course/detail",
				data: {
					courseid: id,
				},
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						shipinxiangqing.fn.dataFill(list);
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});
		},
		
		teacher_list:function(){
			$.ajax({
				type: 'GET',
				url: config.host + "/teachers",
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						shipinxiangqing.fn.teacher_Fill(list);
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});
		},
                comment_list:function(id){
			$.ajax({
				type: 'GET',
				url: config.host + "/video/comment/list",
                                data: {
                                                   token: localStorage.getItem('token'),
                                                   courseid: id,
                                                   
                                           },
				dataType: "jsonp",
				success: function(list) {
					console.log("请求成功");

					if (list.status == 1) {
						//成功操作
						shipinxiangqing.fn.comment_Fill(list);
                                           
					} else {
						$.alert(list.data);
					}
				},
				error: function(xhr, type) {
					console.log("请求失败");
					$.alert('网络异常');
				}
			});
		},
                comment_Fill: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};
                                 for (var i = 0; i < list.data.data.length; i++) {
                                            list.data.data[i].createtime = shipinxiangqing.fn.forData(list.data.data[i].createtime);
                                           
                                         }
                                                /** 
                                  * 对日期进行格式化，
                                  * @param date 要格式化的日期
                                  * @param format 进行格式化的模式字符串
                                  *     支持的模式字母有：
                                  *     y:年,
                                  *     M:年中的月份(1-12),
                                  *     d:月份中的天(1-31),
                                  *     h:小时(0-23),
                                  *     m:分(0-59),
                                  *     s:秒(0-59),
                                  *     S:毫秒(0-999),
                                  *     q:季度(1-4)
                                  * @return String
                                  */
                                 function dateFormat(date, format){

                                     date = new Date(date);
                                     var map = {
                                         "M": date.getMonth() + 1, //月份 
                                         "d": date.getDate(), //日 
                                         "h": date.getHours(), //小时 
                                         "m": date.getMinutes(), //分 
                                         "s": date.getSeconds(), //秒 
                                         "q": Math.floor((date.getMonth() + 3) / 3), //季度 
                                         "S": date.getMilliseconds() //毫秒 
                                     };

                                     format = format.replace(/([yMdhmsqS])+/g, function(all, t){
                                         var v = map[t];
                                         if (v !== undefined) {
                                             if (all.length > 1) {
                                                 v = '0' + v;
                                                 v = v.substr(v.length - 2);
                                             }
                                             return v;
                                         }
                                         else if (t === 'y') {
                                                 return (date.getFullYear() + '').substr(4 - all.length);
                                             }
                                         return all;
                                     });
                                     return format;
                                 }
                                 template.helper("xx", dateFormat);
				var html = template('commentList', data);
				document.getElementById('comment_list').innerHTML = html;
			}
		},
		
		teacher_Fill: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};
                              console.log(data)
				var html = template('teacherList', data);
				document.getElementById('teacher_list').innerHTML = html;
			}
		},
		dataFill: function(list) {
			if (list) {
				var data = {
					files:config.files,
					list: list,
				};

				var html = template('shipinXiangqing', data);
				document.getElementById('shipin_xiangqing').innerHTML = html;
			}
		},

		cordavaDataGet: function() {
			shipinxiangqing.dataInit();
		},
		forData: function(timer) {
			var date = new Date(timer*1000);
			Y = date.getFullYear() + '.';
			M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '.';
			D = date.getDate() + ' ';
			h = date.getHours() + ':';
			m = date.getMinutes() + ':';
			s = date.getSeconds();
			return Y + M + D;
		},
		shipin_by:function(id){
			
			$.ajax({
				type:"get",
				url:config.host+"/course/create",
				data:{
					token:localStorage.getItem('token'),
					courseid:id,
				},
				dataType:"jsonp",
				success:function(data){
					var d = document.getElementById('courseid').value;
					window.location.href="location='../payment/payment.html?t=1&id='"+id;
					if(data.status==1){
						window.location.href="location='../payment/payment.html?t=1&id="+id;
					}else{
						alert(data.data);
					}
				},
				error:function(){
					alert('网络异常');
				}
			});
		},
              comment:function () {
                    var urls = window.location.href;
	            var id = urls.substring(urls.indexOf("=") + 1, urls.length);
                     $.ajax({
                                           type: "get",
                                           url: config.host + "/video/comment/create",
                                           data: {
                                                   token: localStorage.getItem('token'),
                                                   courseid: id,
                                                   content:$('#content').val(),
                                                   
                                           },
                                           dataType: "jsonp",
                                           success: function(data) {
                                                   if (data.status == 1) {
                                                           alert('评论成功');
                                                   } else {
                                                           alert(data.data);
                                                   }
                                           },
                                           error: function() {
                                                   alert('网络异常');
                                           }
                                   });
                }
	}
}
$(function($) {
	shipinxiangqing.fn.cordavaDataGet();
});