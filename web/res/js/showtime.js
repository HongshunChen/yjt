var se,
	minute = 0,
	second = 1;

function showTime() {
	if ((second % 60) == 0) {
		minute += 1;
		second = 1;
	}

	function format(time) {
		return time < 10 ? '0' + time : time;
	}
	t ="已用时 &nbsp;" +format(minute) + ":" + format(second); //时分秒运算
	document.getElementById("showtime").innerHTML = t;
	second += 1;
}
se = setInterval("showTime()", 1000);
