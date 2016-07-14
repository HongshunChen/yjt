/**
 * Created by Administrator on 2016/6/25.
 */

/**
 * 生成选项列表
 */
function createSelectArr (num) {
    var questionSelectArr = new Array;
    for(var i = 0; i < num; i++) {
        questionSelectArr.push(config.selectArr[i]);
    }
    return questionSelectArr;
}

//重新封装http请求, 需要jquery库的支持
function http_request(url,data,succ_callback,err_callback,dataType,type,requestTimes){

    if(!arguments[3]) err_callback = null;
    if(!arguments[4]) dataType = "jsonp";
    if(!arguments[5]) type = "get";
    if(!arguments[6]) requestTimes = 0;

    var token = localStorage.getItem('token') ? localStorage.getItem('token') : '';
    data.token = token;

    $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: dataType,
        success: function(data) {
            var status = data.status;
            if(status == '1'){
                succ_callback(data.data);
            }else{
                if(err_callback != null){
                    err_callback();
                }else{
                    $.alert(data.data);
                }
            }
        },
        error: function(xhr, type) {

            requestTimes++;
            if(requestTimes<3){
                http_request(url,data,succ_callback,err_callback,dataType,type,requestTimes);
            }else{
                $.alert("网络异常");
            }

        }
    });
}

//**************************数据存储相关*********************************start

/**
 * 存储
 */
function localStorageSet (key, value) {
    if(typeof(value) == 'object') {
        value = JSON.stringify(value);
    }
    localStorage.setItem(key, value);
}

/**
 * 获取
 */
function localStorageGet (key) {
    return JSON.parse(localStorage.getItem(key));
}
/**
 * 计时器
 */
function my_timer (times) {
    var h = Math.floor(times/(60 * 60));
    var h_s = (h < 10) ? ('0' + h) : h;

    var m = Math.floor((times - h * 60 * 60)/60);
    var m_s = (m < 10) ? ('0' + m) : m;

    var s = times - h * 60 * 60 - m * 60;
    var s_s = (s < 10) ? ('0' + s) : s;

    times ++;
    $('#timer').html(h_s+":"+m_s+":"+s_s);
    setTimeout('my_timer('+ times +')', 1000);
}
//**************************数据存储相关*********************************end
