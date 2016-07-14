var cuotijiexi = {
    data: {
        paper: null
    },
    dataInit: function() {
        cuotijiexi.fn.errState();
    },
    fn: {
        errState: function () {
            var paper = localStorageGet('paper');
            var _url = config.host + '/exam/errState';
            var _data = {paper_id: paper.paper_id};
            var _paper_type = paper.paper_type;
            http_request(_url, _data, function (data) {
                data.paper_type = _paper_type;
                cuotijiexi.fn.stateRender(data);
                paper.parse_type = 2;
                localStorageSet('paper', paper);
                if (_paper_type != '0') {
                    cuotijiexi.fn.errParse();
                }
            });
        },
        //渲染基本概况
        stateRender: function (stateData) {
            var html = template('err_state_tpl', stateData);
            document.getElementById('err_state_content').innerHTML = html;
        },
        /**
         * 试题解析
         * @param errType, 1: 错题解析, 2: 全部解析
         * @param errList, 错题列表
         */
        errParse: function (keytype) {
            var paper = localStorageGet('paper');
            var _url = config.host + '/exam/paper/parse/list';
            var _data = {
                paper_id: paper.paper_id,
                keytype: keytype ? keytype : paper.parse_type
            }
            http_request(_url, _data, function (data) {
                cuotijiexi.fn.parseRender(data);
            })
        },
        //错题解析渲染
        parseRender: function (parseData) {
            var data = {
                list: parseData
            };
            var html = template('err_parse_tpl', data);
            document.getElementById('err_parse_content').innerHTML = html;
        }
    }
}
$(function() {
    cuotijiexi.dataInit();
});