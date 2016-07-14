/**
 * Created by Administrator on 2016/6/29.
 */
var _choice = {
    data: {
        module : {
            '1': 'danxuan',
            '2': 'duoxuan',
            '3': 'panduan'
        }
    },
    dataInit: function() {

    },
    fn: {
        //根据题型生成试卷
        createExam: function (keytype, questid, areaname) {

            if(!arguments[0]) areaname = '';

            var url = config.host + '/exam/create';
            var _data = {
                keytype: keytype,
                questid: questid,
                areaname: areaname
            }
            http_request(url, _data, function (data) {
                var paper = {
                    paper_id: data.paper_id,
                    current_question_no: 1,
                    total_count: data.total_count,
                    paper_type: questid
                };
                localStorageSet('paper', paper);
                //window.location.href = './' + _choice.data.module[questid] + '.html'
                window.location.href = './danxuan.html'
            })
        }
    }
}