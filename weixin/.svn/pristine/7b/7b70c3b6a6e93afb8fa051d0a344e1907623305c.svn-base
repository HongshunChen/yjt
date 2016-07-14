function daojishi(times) {
	var btn = document.getElementById("biaozhi_code");
	if (times <= 0) {
		btn.removeAttribute("disabled");
		btn.value = "重新获取验证码";
		sendFlag = true;
	} else {
		btn.setAttribute("disabled", true);
		btn.value = "重新发送(" + times + ")";
		times -= 1;
		setTimeout(function() {
			daojishi(times)
		}, 1000);
	}
}