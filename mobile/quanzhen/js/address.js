/**
 * Created by Administrator on 2016/6/30.
 */
var address = {
    data: {
        paper: null
    },
    dataInit: function() {
        address.fn.getAreaList();
    },
    fn: {
        getAreaList: function () {
            var _url = config.host + '/area/list';
            var _data = {
                keytype: 2
            };
            http_request(_url, _data, function (data) {
                address.fn.fillData(data);
            });
        },
        fillData: function (data) {
            var len = data.length;
            var groups = Math.ceil(len/4);
            var address = '[';
            for (var i=0; i < groups; i++) {
                var address_sub = '[';

                address_sub += '{"area":' + '"' + data[i * 4].area + '"},';

                if(i * 4 + 1 < len) {
                    address_sub += '{"area":' + '"' + data[i * 4 + 1].area + '"},';
                }

                if(i * 4 + 2 < len) {
                    address_sub += '{"area":' + '"' + data[i * 4 + 2].area + '"},';
                }

                if(i * 4 + 3 < len) {
                    address_sub += '{"area":' + '"' + data[i * 4 + 3].area + '"},';
                }
                address_sub = address_sub.substring(0, address_sub.length - 1);
                address_sub += ']';
                address += '{"address_sub":' +  address_sub + '},';
            }
            address = address.substring(0, address.length - 1);
            address += ']';

            address = JSON.parse(address);
            var data = {
                address: address
            };
            var html = template('address_tpl', data);
            console.log(html);
            document.getElementById('address_content').innerHTML = html;
        },
        createExam: function (keytype, questid, areaname) {

            if(!arguments[2]) areaname = document.getElementById('search').value;
            console.log(areaname);

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
                    paper_type: 0//代表全真模拟
                };
                localStorageSet('paper', paper);
                //window.location.href = './' + _choice.data.module[questid] + '.html'
                window.location.href = '../keguanti/danxuan.html'
            })
        }
    }
}
$(function() {
    address.dataInit();
});