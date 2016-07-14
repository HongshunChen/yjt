//动态显示年月日时间和周几，加载到页面确定ID上
function get_now(id) {
	var obj = window.document.getElementById(id);
	var date = new Date();
	var year = date.getFullYear();
	var month = get_now_addzero(date.getMonth() + 1);
	var day = get_now_addzero(date.getDate());
	var hour = get_now_addzero(date.getHours());
	var minute = get_now_addzero(date.getMinutes());
	var second = get_now_addzero(date.getSeconds());
	switch (date.getDay()) {
		case 0:
			week = "星期天";
			break
		case 1:
			week = "星期一";
			break
		case 2:
			week = "星期二";
			break
		case 3:
			week = "星期三";
			break
		case 4:
			week = "星期四";
			break
		case 5:
			week = "星期五";
			break
		case 6:
			week = "星期六";
			break
	}
	//格式为：年月日 时分秒 星期，如变更格式，请自行更新下方格式约束代码
	obj.innerHTML = year + "年" + month + "月" + day + "日 " + week;
	//obj.innerHTML = year + "年" + month + "月" + day + "日 " + hour + ":" + minute + ":" + second + " " + week;
	//下方启用时间自动刷新，如不需要可注释掉，间隔为1000毫秒，即每秒刷新一次
	setTimeout("get_now('" + id + "')", 1000);
}

//如下代码为单数补0，当小于10时，在前方加一个0，用于单月或单日情况，前面补0。例：3月转换为03月
function get_now_addzero(temp) {
	if (temp < 10) return "0" + temp;
	else return temp;
}

//获取当前时间的：时分
function get_nowtime() {
	var date = new Date();
	var hour = get_now_addzero(date.getHours());
	var minute = get_now_addzero(date.getMinutes());
	var thistime = hour + ":" + minute;
	return thistime;
}

//此函数简单计算迟到、早退、缺勤时间而用。
function get_newtime(times, minutes, operator) {
	var this_date = config.Helpers.dateLocaleString(new Date()) + " " + times;
	this_date = this_date.replace(/-/g, "/"); //更改日期格式      
	var nd = new Date(this_date);
	nd = nd.valueOf();
	if (operator == "+") {
		nd = nd + minutes * 60 * 1000;
	} else if (operator == "-") {
		nd = nd - minutes * 60 * 1000;
	} else {
		return false;
	}
	nd = new Date(nd);
	var h = nd.getHours();
	var m = nd.getMinutes();
	var newtime = h + ":" + m;
	return newtime;
}

