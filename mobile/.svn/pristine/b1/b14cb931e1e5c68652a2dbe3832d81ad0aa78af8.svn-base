var pinggu = {
	data: {
		paper: null
	},
	dataInit: function() {
		pinggu.fn.getReport();
	},
	fn: {
		getReport: function () {

			var paper = localStorageGet('paper');

			var _url = config.host + 'exam/getReport';
			var _data = {
				paper_id: paper.paper_id
			}
			http_request(_url, _data, function (data) {
				pinggu.fn.dataFill(data);
			});

		},
		dataFill: function(data) {
			if (data) {
				console.log(data);
				var html = template('pinggu_tpl', data);
				document.getElementById('pinggu_content').innerHTML = html;
			}
		},
	}
}
$(function($) {
	pinggu.dataInit();
});