var zibei = {
	data: {},
	dataInit: function() {

	},
	eventBind: function() {},
	fn: {
		pigai: function() {

			var question = $("#images_question").attr('src');
			var answer = $("#images_answer").attr('src');

			var _url = config.host + '/self/upload';
			var _data = {
				'question_type': 2,
				'question': question,
				'answer_type': 2,
				'answer': answer
			};
			http_request(_url, _data, function (data) {

			}, null, 'json', 'post');

		},
		cordavaDataGet: function() {},
	}
}
Zepto(function($) {
	zibei.fn.cordavaDataGet();
});