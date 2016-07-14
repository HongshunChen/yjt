function quit_user() {
	if (confirm('你确定要退出吗？')) {                            
		localStorage.clear();    
		window.location.href='../login_register/deng.html';
	}
}

