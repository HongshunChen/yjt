<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
/**
 * 文档路由, 正式部署时删除
 */
Route::get('/doc', function () {
	return view('doc');
});
Route::get('/demo', 'Demo\DemoController@index');

//********************通用相关*********************start
Route::get('/init', 'Common\InitController@index');
Route::get('/area/list', 'Common\AreaController@index');
//********************通用相关**********************end

//*****************用户相关************************start
Route::get('/send_message', 'User\MessageController@send');
Route::get('/reg', [
	'middleware' => ['verifycode', 'reg'],
	'uses' => 'User\RegController@store'
]);
Route::get('/login', 'User\LoginController@index');
Route::get('/password/back', [
	'middleware' => ['verifycode'],
	'uses' => 'User\PwdController@getBack'
]);

Route::get('/teachers', 'User\TeacherController@index');

//*****************用户相关************************start

Route::get('/exam/questypes', 'Exam\QuestypeController@index');

//所有课程列表
Route::get('/course/list', 'Video\CourseController@index');
//课程详细介绍
Route::get('/course/detail', 'Video\CourseController@detail');

//直播课列表
Route::get('/course/livelist', 'Video\CourseLiveController@index');
//详细介绍
Route::get('/course/livedetail', 'Video\CourseLiveController@detail');

//获取类别列表
Route::get('/course/type', 'Video\CourseController@getcate');

//成员统计
Route::get('/members', 'Common\StatisController@members');

/**
 * 需要身份验证的路由
 * 
 */
Route::group(['middleware' => 'jwt.auth'], function () {
		
	Route::get('/pssword/retrieve', 'User\PwdController@retrieve');
	Route::get('/user/info', 'User\InfoController@index');
	Route::get('user/info/update', 'User\InfoController@update');

	Route::get('/collect/update', 'User\CollectController@update');
	Route::get('/collect/getList', 'User\CollectController@getList');
	Route::get('/collect/getOne', 'User\CollectController@getOne');

	//************************试卷相关********************************start
	
	Route::get('/exam/create', 'Exam\ExamController@create');
	Route::get('/exam/getOne', 'Exam\ExamController@getOne');
	Route::get('/exam/submitOne', 'Exam\ExamController@submitOne');
	Route::post('/exam/submitOne', 'Exam\ExamController@submitOne');
	Route::get('/exam/assignment', 'Exam\ExamController@assignment');
	Route::get('/exam/getReport', 'Exam\ExamController@getReport');
	Route::get('/exam/errState', 'Exam\ExamController@errState');
	Route::get('/exam/parsePaper', 'Exam\ExamController@parsePaper');
	Route::get('/exam/paper/parse/list', 'Exam\ExamController@parsePaperList');

	Route::get('/exam/getCoupon', 'Coupon\CouponController@getCoupon');
	Route::get('/coupon/list', 'Coupon\CouponController@getList');

	//全真模拟的全部试题
	Route::get('/exam/simulate', 'Exam\ExamController@simulate');

	//自备题
	Route::get('self/upload', 'Exam\SelfQuesController@upload');

	//************************视频相关************************************start
    //我的课程
	Route::get('/video/mylist', 'Video\VideoController@myindex');
	//我的直播课
	Route::get('/video/mylivelist', 'Video\VideoController@myliveindex');
     //缓存视频
	Route::get('/video/mylib', 'Video\VideoController@mylib');
	//练习中心
	Route::get('/video/mysublist', 'Video\VideoController@mysublist');
	//插入购买成功后的视频
	Route::get('/course/create', 'Video\VideoController@create');
	//插入购买成功后的直播课
	Route::get('/course/createlive', 'Video\VideoController@createlive');
	//插入观看视频历史记录
	Route::get('/course/createlib', 'Video\VideoController@createlib');



	//*************************订单相关*******************************start

	//订单回调
	Route::get('order/callback', 'Order\OrderController@orderCallback');

	//*************************订单相关*******************************end



});

//文件上传测试
Route::post('file/test', 'Common\FileController@test');

Route::post('self/upload', 'Exam\SelfQuesController@upload');
