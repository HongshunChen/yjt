
var timestamp = new Date().getTime();

var nav = [
	{
		"title": "通用相关",
		"sub": [
			{
				"title": "初始化",
				"type":"get",
				"url":"/init",
				"require": [
					
				],
				"response": [
					{"name": "file_root","desc": "文件根目录"},
				]
			},
			{
				"title": "地区列表",
				"type":"get",
				"url":"/area/list",
				"require": [
					
				],
				"response": [
					{"name": "group","desc": "地区分组名, 如: 华东, 华北"},
					{"name": "children","desc": "分组下的地区列表, 字段如下,areaid:主键id; area:名称,如北京; areacode:地区编号"},
				]
			},
			{
				"title": "各模块成员数",
				"type":"get",
				"url":"/members",
				"require": [

				],
				"response": [
					{"name": "video","desc": "视频参与人数"},
					{"name": "live","desc": "直播参与人数"},
					{"name": "objective","desc": "客观题参与人数"},
					{"name": "subjective","desc": "主观题参与人数"},
					{"name": "simulate","desc": "模拟题参与人数"},
				]
			},
		]
	},
	{
		"title": "用户相关",
		"sub": [
			{
				"title": "发送验证码",
				"type":"get",
				"url":"/send_message",
				"require": [
					{"name": "username","desc": "手机号", "default": ""},
				],
				"response": [
				]
			},
			{
				"title": "用户注册",
				"type":"get",
				"url":"/reg",
				"require": [
					{"name": "username","desc": "用户名", "default": ""},
					{"name": "userpassword","desc": "用户密码", "default": ""},
					{"name": "verifycode","desc": "验证码", "default": ""}
				],
				"response": [
					{"name": "token","desc": "登录令牌"},
				]
			},
			{
				"title": "用户登录",
				"type":"get",
				"url":"/login",
				"require": [
				    {"name": "username","desc": "用户名(手机号)"},
					{"name": "userpassword","desc": "用户密码"}
				],
				"response": [
					{"name": "token","desc": "登录令牌"},
				]
			},
			{
				"title": "修改密码",
				"type":"get",
				"url":"/pssword/retrieve",
				"require": [
					{"name": "token","desc": "登录令牌", "default": ""},
					{"name": "old_userpassword","desc": "旧密码", "default": ""},
					{"name": "new_userpassword","desc": "新密码", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "找回密码",
				"type":"get",
				"url":"/password/back",
				"require": [
					{"name": "username","desc": "手机号", "default": ""},
					{"name": "verifycode","desc": "验证码", "default": ""},
					{"name": "userpassword","desc": "密码", "default": ""},
				],
				"response": [
					{"name": "token","desc": "登录令牌", "default": ""},
				]
			},
			{
				"title": "获取用户基本信息",
				"type":"get",
				"url":"/user/info",
				"require": [
					{"name": "token","desc": "登录令牌", "default": ""},
				],
				"response": [
					{"name": "userid","desc": "用户主键id" },
					{"name": "username","desc": "用户名(手机号)" },
					{"name": "usercoin","desc": "用户余额" },
					{"name": "nickname","desc": "用户昵称" },
				]
			},
			{
				"title": "修改基本信息",
				"type":"get",
				"url":"/user/info/update",
				"require": [

					{"name": "token","desc": "登录令牌", "default": ""},
					{"name": "nickname","desc": "用户昵称", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "名师列表",
				"type":"get",
				"url":"/teachers",
				"require": [
				],
				"response": [
					{"name": "userid","desc": "用户主键id" },
					{"name": "username","desc": "手机号" },
					{"name": "photo","desc": "头像" },
					{"name": "usertruename","desc": "真实姓名" },
					{"name": "teacher_subjects","desc": "描述" },
					{"name": "title","desc": "称号" },
					{"name": "score","desc": "评分" },
				]
			}
		]
	},
	{
		"title": "收藏相关",
		"sub": [
			{
				"title": "收藏/取消收藏",
				"type":"get",
				"url":"/collect/update",
				"require": [
					{"name": "token","desc": "登录令牌", "default": ""},
					{"name": "questionid","desc": "要收藏/取消收藏的试题id", "default": ""},
				],
				"response": [
					{"name": "tips","desc": "操作完成提示信息"},
				]
			},
			{
				"title": "收藏列表",
				"type":"get",
				"url":"/collect/getList",
				"require": [
					{"name": "token","desc": "登录令牌", "default": ""},
					{"name": "questiontype","desc": "获取类型, 1: 单选, 2: 多选....", "default": "1"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "favorid","desc": "收藏主键id"},
					{"name": "question","desc": "题目"},
					{"name": "questiontype","desc": "题目类型"},
					{"name": "questionselect","desc": "问题选项, 如果是客观题的话"},
					{"name": "questionanswer","desc": "正确答案, 如果是客观题的话"},
					{"name": "questiondescribe","desc": "问题解析"},
				]
			},
			{
				"title": "收藏详情",
				"type":"get",
				"url":"/collect/getOne",
				"require": [
					{"name": "token","desc": "登录令牌", "default": ""},
					{"name": "favorid","desc": "收藏主键id", "default": ""},
				],
				"response": [
					{"name": "favorid","desc": "收藏主键id"},
					{"name": "question","desc": "题目"},
					{"name": "questiontype","desc": "题目类型"},
					{"name": "questionselect","desc": "问题选项, 如果是客观题的话"},
					{"name": "questionanswer","desc": "正确答案, 如果是客观题的话"},
					{"name": "questiondescribe","desc": "问题解析"},
				]
			},

		]
	},
	{
		"title": "在线刷题",
		"sub": [
			{
				"title": "试题类型列表",
				"type":"get",
				"url":"/exam/questypes",
				"require": [
					{"name": "type","desc": "获取列表类型, 0:获取全部类型, 1: 获取客观题类型, 2: 获取主观题类型"},
				],
				"response": [
					{"name": "questid","desc": "试题类型id"},
					{"name": "questionid","desc": "试题类型名称"},
					{"name": "type","desc": "试题类型的类型, 1:客观题, 2:主观题"},
				]
			},
			{
				"title": "生成试卷",
				"type":"get",
				"url":"/exam/create",
				"require": [
					{"name": "token","desc": "登录令牌"},
					{"name": "keytype","desc": "试卷类型", "default": "1"},
					{"name": "questid","desc": "要获取的题目类型id, 从题目类型列表获得的主键id", "default": "1"},
					{"name": "areaname","desc": "地区名称", "default": "全国"},
				],
				"response": [
					{"name": "paper_id","desc": "试卷主键id"},
					{"name": "keytype","desc": "试卷类型, 1: 普通联系, 2: 全真模拟"},
					{"name": "questid","desc": "类型id"},
					{"name": "total_count","desc": "题数"},
					{"name": "total_score","desc": "总分"},
					{"name": "created_at","desc": "试卷创建时间"},
				]
			},
			{
				"title": "获取单条试题",
				"type":"get",
				"url":"/exam/getOne",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
					{"name": "question_no","desc": "题号,如获取该试卷第一题就传1, ...", "default": ""},
				],
				"response": [
					{"name": "id","desc": "对应试卷的试题主键id"},
					{"name": "paper_id","desc": "试卷id"},
					{"name": "question","desc": "问题"},
					{"name": "questionid","desc": "题目id"},
					{"name": "questiontype","desc": "题型类别"},
					{"name": "questionselect","desc": "问题选项"},
					{"name": "questionselectnumber","desc": "问题选项数量"},
					{"name": "questiondescribe","desc": "问题描述"},
					{"name": "answered","desc": "回答的答案, 用于查看上一题时"},
					{"name": "question_no","desc": "问题题号"},
					{"name": "prev","desc": "上一题题号, 如果为0, 表示没有上一题了(前端自己算也可以)"},
					{"name": "next","desc": "下一题题号, 如果为0, 表示没有下一题了(前端自己算也可以)"},
					{"name": "is_favor","desc": "是否收藏, 0: 否, 1: 是"},
				]
			},
			{
				"title": "获取整套模拟试卷",
				"type":"get",
				"url":"/exam/simulate",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
				],
				"response": [
					{"name": "paper_id","desc": "试卷id"},
					{"name": "radio","desc": "单选列表", "sub": [
						{"name": "total_num","desc": "对应题型题数"},
						{"name": "total_score","desc": "对应题型总分"},
						{"name": "list","desc": "对应题型的列表, 列表字段如下", "sub": [
							{"name": "id","desc": "对应试卷的试题主键id"},
							{"name": "question","desc": "问题"},
							{"name": "questiontype","desc": "题型类别"},
							{"name": "questionselect","desc": "问题选项"},
							{"name": "questionselectnumber","desc": "问题选项数量"},
							{"name": "questiondescribe","desc": "问题描述"},
							{"name": "answered","desc": "回答的答案, 用于查看上一题时"},
						]},
					]},
					{"name": "multiple","desc": "单选列表", "sub": [
						{"name": "total_num","desc": "对应题型题数"},
						{"name": "total_score","desc": "对应题型总分"},
						{"name": "list","desc": "对应题型的列表, 列表字段如下", "sub": [
							{"name": "id","desc": "对应试卷的试题主键id"},
							{"name": "question","desc": "问题"},
							{"name": "questiontype","desc": "题型类别"},
							{"name": "questionselect","desc": "问题选项"},
							{"name": "questionselectnumber","desc": "问题选项数量"},
							{"name": "questiondescribe","desc": "问题描述"},
							{"name": "answered","desc": "回答的答案, 用于查看上一题时"},
						]},
					]},
					{"name": "judgement","desc": "单选列表", "sub": [
						{"name": "total_num","desc": "对应题型题数"},
						{"name": "total_score","desc": "对应题型总分"},
						{"name": "list","desc": "对应题型的列表, 列表字段如下", "sub": [
							{"name": "id","desc": "对应试卷的试题主键id"},
							{"name": "question","desc": "问题"},
							{"name": "questiontype","desc": "题型类别"},
							{"name": "questionselect","desc": "问题选项"},
							{"name": "questionselectnumber","desc": "问题选项数量"},
							{"name": "questiondescribe","desc": "问题描述"},
							{"name": "answered","desc": "回答的答案, 用于查看上一题时"},
						]},
					]},
					{"name": "subject","desc": "单选列表", "sub": [
						{"name": "total_num","desc": "对应题型题数"},
						{"name": "total_score","desc": "对应题型总分"},
						{"name": "list","desc": "对应题型的列表, 列表字段如下", "sub": [
							{"name": "id","desc": "对应试卷的试题主键id"},
							{"name": "question","desc": "问题"},
							{"name": "questiontype","desc": "题型类别"},
							{"name": "questionselect","desc": "问题选项"},
							{"name": "questionselectnumber","desc": "问题选项数量"},
							{"name": "questiondescribe","desc": "问题描述"},
							{"name": "answered","desc": "回答的答案, 用于查看上一题时"},
						]},
					]},

				]
			},
			{
				"title": "提交单条试题",
				"type":"get",
				"url":"/exam/submitOne",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_question_id","desc": "试卷试题的主键id, 获取试题时的主键id", "default": ""},
					{"name": "answertype","desc": "答案类型, 1: 文本答案, 2:图片答案(base64), 3: 图片文件上传", "default": "1"},
					{"name": "answered","desc": "对应试题的答案", "default": ""},
					{"name": "answer_file","desc": "文件, answertype=3 时的文件名字段", "type": "file", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "交卷",
				"type":"get",
				"url":"/exam/assignment",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "获取报告",
				"type":"get",
				"url":"/exam/getReport",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
				],
				"response": [
					{"name": "scored","desc": "得分"},
					{"name": "did_num_total","desc": "已做题量"},
					{"name": "did_days","desc": "已做天数"},
					{"name": "couponvalue","desc": "现金券"},
					{"name": "err_num","desc": "累计错题数"},
					{"name": "err_win_rate","desc": "错题找过用户率"},
					{"name": "hours","desc": "本次做题使用小时数"},
					{"name": "minutes","desc": "本次做题使用分钟数"},
					{"name": "seconds","desc": "本次做题使用秒数"},
					{"name": "correct_rate","desc": "本次考试正确率"},
					
				]
			},
			{
				"title": "错题概况",
				"type":"get",
				"url":"/exam/errState",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
				],
				"response": [
					{"name": "paper_id","desc": "试卷id"},
					{"name": "did_num","desc": "做题数"},
					{"name": "correct_num","desc": "做对数"},
					{"name": "scored","desc": "得分"},
					{"name": "err_list","desc": "错题列表", "sub": [
						{"name": "question_no","desc": "错误题号"},
					]},
				]
			},
			{
				"title": "试题解析",
				"type":"get",
				"url":"/exam/parsePaper",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
					{"name": "question_no","desc": "对应试卷的试题编号", "default": ""},
				],
				"response": [
					{"name": "question_no","desc": "试题编号"},
					{"name": "question","desc": "问题"},
					{"name": "questionselect","desc": "选项"},
					{"name": "questionanswer","desc": "正确答案"},
					{"name": "answered","desc": "我的答案"},
					{"name": "questiondescribe","desc": "问题解析"},
				]
			},
			{
				"title": "试题解析列表",
				"type":"get",
				"url":"/exam/paper/parse/list",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
					{"name": "keytype","desc": "获取类型, 1:获取全部试题解析, 2: 获取错题解析", "default": ""},
				],
				"response": [
					{"name": "question_no","desc": "试题编号"},
					{"name": "question","desc": "问题"},
					{"name": "questionselect","desc": "选项"},
					{"name": "questionanswer","desc": "正确答案"},
					{"name": "answered","desc": "我的答案"},
					{"name": "questiondescribe","desc": "问题解析"},
				]
			},

		]
	},
		{
		"title": "视频相关",
		"sub": [
			///
			{
				"title": "课程类别",
				"type":"get",
				"url":"course/type",
				"require": [
				],
				"response": [
					{"name": "catid","desc": "ID"},
					{"name": "catname","desc": "类别名"},
				]
			},
			{
				"title": "视频课程",
				"type":"get",
				"url":"/course/list",
				//c（可选） n（可选） k（可选）
				"require": [
					{"name": "token","desc": "登录令牌, 选传, 如果是登录状态,就传该字段"},
					{"name": "c","desc": "课程内容分类"},
					{"name": "n","desc": "课程类别分类"},
					{"name": "k","desc": "考试类别"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "courseid","desc": "ID"},
					{"name": "coursename","desc": "课程名称"},
					{"name": "courseusername","desc": "主讲老师"},
					{"name": "courseprice","desc": "课程价格"},
					{"name": "coursethumb","desc": "图片地址"},
					{"name": "is_buy","desc": "是否已购买, 0: 否, 1:是"},
				]
			},
			{
				"title": "视频课程详情",
				"type":"get",
				"url":"/course/detail",
				"require": [
					{"name": "courseid","desc": "视频课程ID"},
				],
				"response": [
					{"name": "coursename","desc": "课程名称"},
					{"name": "courseintro","desc": "课程简介"},
					{"name": "teacherid","desc": "讲课人ID"},
					{"name": "teachername","desc": "讲课人名称"},
					{"name": "teacherthumb","desc": "讲课人图片"},
					{"name": "teacherintro","desc": "讲课人简介"},
					{"name": "contentintro","desc": "课程内容"},
					{"name": "courseprice","desc": "课程价格"},
					{"name": "coursethumb","desc": "课程首图"},
				]
			},
			{
				"title": "直播课",
				"type":"get",
				"url":"/course/livelist",
				"require": [
					{"name": "c","desc": "课程内容分类"},
					{"name": "n","desc": "课程类别分类"},
					{"name": "k","desc": "考试类别"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "vurl","desc": "视频地址"},
					{"name": "usertruename","desc": "讲课人名称"},
					{"name": "vname","desc": "视频名称"},
					{"name": "vintro","desc": "视频简介"},
					{"name": "vprice","desc": "价格"},
					{"name": "createtime","desc": "开课时间"},
					{"name": "endtime","desc": "结束时间"},
				]
			},
			{
				"title": "直播课详情",
				"type":"get",
				"url":"/course/livedetail",
				"require": [
					{"name": "vid","desc": "ID"},
				],
				"response": [
					{"name": "vname","desc": "视频名称"},
					{"name": "vintro","desc": "视频简介"},
					{"name": "teacherid","desc": "讲课人ID"},
					{"name": "teachername","desc": "讲课人名称"},
					{"name": "teacherthumb","desc": "讲课人图片"},
					{"name": "teacherintro","desc": "讲课人简介"},
					{"name": "vcontent","desc": "视频内容"},
					{"name": "vprice","desc": "视频价格"},
					{"name": "vurl","desc": "视频地址"},
				]
			},

			{
				"title": "插入视频（订单）",
				"type":"get",
				"url":"/course/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "courseid","desc": "视频课程主键id", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "插入直播课（订单）",
				"type":"get",
				"url":"/course/createlive",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "vid","desc": "直播课主键id", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "插入视频缓存记录",
				"type":"get",
				"url":"/course/createlib",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "videoid","desc": "视频主键id", "default": ""},
				],
				"response": [

				]
			},
		]
	},
	{
		"title": "优惠券相关",
		"sub": [
			{
				"title": "领取优惠券",
				"type":"get",
				"url":"/exam/getCoupon",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "paper_id","desc": "试卷主键id", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "优惠券列表",
				"type":"get",
				"url":"/coupon/list",
				"require": [
					{"name": "token","desc": "token", "default": ""},
				],
				"response": [
					{"name": "couponsn","desc": "优惠券码"},
					{"name": "couponvalue","desc": "优惠券额度"},
					{"name": "couponendtime","desc": "过期时间"},
				]
			},
		]
	},
	{
		"title": "个人中心",
		"sub": [
			{
				"title": "我的课程",
				"type":"get",
				"url":"/video/mylist",
				"require": [
					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "remoteurl","desc": "播放地址"},
					{"name": "courseusername","desc": "主讲讲师姓名"},
					{"name": "videoname","desc": "视频名称"},
					{"name": "duration","desc": "时长"},
					{"name": "courseprice","desc": "总的课程价格"},
					{"name": "createtime","desc": "发布时间"},
					{"name": "coursethumb","desc": "图片"},
					{"name": "is_expired","desc": "课程是否过期, 0: 没过期, 1: 已过期"},
				]
			},
			{
				"title": "课程介绍",
				"type":"get",
				"url":"/course/detail",
				"require": [
					{"name": "courseid","desc": "视频课程ID"},
				],
				"response": [
					{"name": "coursename","desc": "课程名称"},
					{"name": "courseintro","desc": "课程简介"},
					{"name": "teacherid","desc": "讲课人ID"},
					{"name": "teachername","desc": "讲课人名称"},
					{"name": "teacherthumb","desc": "讲课人图片"},
					{"name": "teacherintro","desc": "讲课人简介"},
					{"name": "contentintro","desc": "课程内容"},
					{"name": "courseprice","desc": "课程价格"},
					{"name": "coursethumb","desc": "课程首图"},
				]
			},
			{
				"title": "我的直播课",
				"type":"get",
				"url":"/video/mylivelist",
				"require": [
					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "vurl","desc": "视频地址"},
					{"name": "usertruename","desc": "讲课人名称"},
					{"name": "vname","desc": "视频名称"},
					{"name": "vintro","desc": "视频简介"},
					{"name": "vprice","desc": "价格"},
					{"name": "createtime","desc": "开课时间"},
					{"name": "endtime","desc": "结束时间"},

				]
			},
			{
				"title": "缓存视频",
				"type":"get",
				"url":"/video/mylib",
				"require": [
					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "remoteurl","desc": "播放地址"},
					{"name": "courseusername","desc": "主讲讲师姓名"},
					{"name": "videoname","desc": "视频名称"},
					{"name": "duration","desc": "时长"},
					{"name": "courseprice","desc": "课程价格"},
					{"name": "createtime","desc": "上次观看时间"},
				]
			},
			{
				"title": "练习中心",
				"type":"get",
				"url":"/video/mysublist",
				"require": [
					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],

				"response": [
					{"name": "videourl","desc": "视频地址"},
					{"name": "usertruename","desc": "讲课人名称"},
					{"name": "usertime","desc": "用户提交时间"},
					{"name": "teachertime","desc": "教师回答时间"},
					{"name": "ordersn","desc": "订单编号"},
					{"name": "orderprice","desc": "订单价格"},

				]
			},
		]
	},
	{
		"title": "自备题",
		"sub": [
			{
				"title": "上传",
				"type":"post",
				"url":"/self/upload",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "question_type","desc": "上传问题方式, 1: 文本, 2: 图片(base64), 3: 图片(文件)", "default": ""},
					{"name": "question","desc": "问题内容, answer_type=1, 为问题文本答案, answer_type=2时, 为base64编码的文件内容, 3时传空", "default": ""},
					{"name": "question_file","desc": "问题图片文件", "type": "file", "default": ""},
					{"name": "answer_type","desc": "答案类型, 1: 文本, 2: 图片(base64)，3: 图片(文件)", "default": ""},
					{"name": "answer","desc": "答案内容, answer_type=1, 为文本答案, answer_type=2时, 为base64编码的文件内容, 3时传空", "default": ""},
					{"name": "answer_file","desc": "答案图片文件", "type": "file", "default": ""},
				],
				"response": [

				]
			},
		]
	},
	{
		"title": "文件相关",
		"sub": [
			{
				"title": "测试",
				"type":"post",
				"url":"/file/test",
				"require": [
					{"name": "my_file","desc": "文件", "type": "file", "default": ""},
				],
				"response": [

				]
			},
		]
	},
//	,
//	{
//		"title": "主观题批改",
//		"sub": [
//			{
//				"title": "上传自备题",
//				"type":"get",
//				"url":"/user/addfavor",
//				"require": [
//					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
//					{"name": "userid","desc": "用户编号"},
//					{"name": "questionurl","desc": "题目地址", "default": ""},
//					{"name": "answerrul","desc": "答案地址", "default": ""},
//				],
//				"response": [
//					{"name": "code","desc": "1"},
//					{"name": "questionid","desc": "返回自备试卷ID"}
//				]
//			},
//			{
//				"title": "随机抽题",
//				"type":"get",
//				"url":"/user/favorList",
//				"require": [
//					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
//					{"name": "userid","desc": "用户编号"},
//					{"name": "questiontype","desc": "题目类型"},
//				],
//				"response": [
//					{"name": "questionid","desc": "题目ID"},
//					{"name": "question","desc": "题目"},
//					{"name": "useranswer","desc": "用户答案"},
//				]
//			},
//			{
//				"title": "提交答案",
//				"type":"get",
//				"url":"/user/questiondetail",
//				"require": [
//					{"name": "userid","desc": "用户id", "default": ""},
//					{"name": "token","desc": "token", "default": ""},
//					{"name": "question","desc": "题目"},
//					{"name": "useranswer","desc": "答案"},
//				],
//				"response": [
//					{"name": "code","desc": "1"},
//					{"name": "message","desc": "提交成功"}
//				]
//			},
//			{
//				"title": "主观题列表",
//				"type":"get",
//				"url":"/user/myquestion",
//				"require": [
//					{"name": "userid","desc": "用户id", "default": ""},
//					{"name": "token","desc": "token", "default": ""},
//					{"name": "questiontype","desc": "题目类型"},
//
//				],
//				"response": [
//					{"name": "id","desc": "编号"},
//					{"name": "type","desc": "类型"},
//					{"name": "meney","desc": "金额"},
//					{"name": "ispay","desc": "是否付费"}
//				]
//			}
//			,
//			{
//				"title": "主观题详情",
//				"type":"get",
//				"url":"/user/myquestiondetail",
//				"require": [
//					{"name": "userid","desc": "用户id", "default": ""},
//					{"name": "token","desc": "token", "default": ""},
//					{"name": "questionid","desc": "主观题编号"},
//
//				],
//				"response": [
//					{"name": "id","desc": "编号"},
//					{"name": "type","desc": "类型"},
//					{"name": "meney","desc": "金额"},
//					{"name": "ispay","desc": "是否付费"},
//					{"name": "question","desc": "问题"},
//					{"name": "useranswer","desc": "用户答案"},
//					{"name": "teacheranswer","desc": "专家答案"}
//				]
//			}
//		]
//	},
//	{
//		"title": "视频课程",
//		"sub": [
//			{
//				"title": "视频课程列表",
//				"type":"get",
//				"url":"/user/videolist",
//				"require": [
//					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
//					{"name": "userid","desc": "用户编号"},
//					{"name": "courseify3","desc": "类别1", "default": ""},
//					{"name": "courseify2","desc": "类别2", "default": ""},
//					{"name": "courseify3","desc": "类别3", "default": ""},
//				],
//				"response": [
//					{"name": "courseid","desc": "课程ID"},
//					{"name": "coursename","desc": "课程名称"},
//					{"name": "courseusername","desc": "主讲讲师姓名"},
//					{"name": "courseprice","desc": "课程价格"},
//					{"name": "coursethumb","desc": "课程首图"},
//				]
//			},
//			{
//				"title": "视频课程详情",
//				"type":"get",
//				"url":"/user/videodetail",
//				"require": [
//					{"name": "userid","desc": "用户id", "default": ""},
//					{"name": "token","desc": "token", "default": ""},
//					{"name": "courseid","desc": "视频课程ID"},
//				],
//				"response": [
//					{"name": "coursename","desc": "课程名称"},
//					{"name": "courseintro","desc": "课程简介"},
//					{"name": "teacherid","desc": "讲课人ID"},
//					{"name": "teachername","desc": "讲课人名称"},
//					{"name": "teacherthumb","desc": "讲课人图片"},
//					{"name": "teacherintro","desc": "讲课人简介"},
//					{"name": "contentintro","desc": "课程内容"},
//					{"name": "courseprice","desc": "课程价格"},
//					{"name": "coursethumb","desc": "课程首图"},
//				]
//			},
//			{
//				"title": "我的视频列表（已购买）",
//				"type":"get",
//				"url":"/user/geterrorlist",
//				"require": [
//					{"name": "token","desc": "065F733E4EEA5360EDE4C89929014A0B"},
//					{"name": "userid","desc": "用户编号"},
//				],
//				"response": [
//					{"name": "videoid","desc": "视频ID"},
//					{"name": "videoname","desc": "视频名称"},
//					{"name": "remoteurl","desc": "视频地址"},
//					{"name": "videohumb","desc": "视频图片"},
//					{"name": "gettime","desc": "购买时间"},
//				]
//			},
//
//		]
//	}
]