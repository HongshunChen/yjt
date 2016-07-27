<?php
/**
 * Created by zjs.
 * User: alan
 * Date: 2016/6/16
 * Time: 17:42
 * ********************************************************
 * 我的课程
 * 直播课
 * 缓存纪录
 * 练习中心
 * 插入购买成功后的视频
 * 插入购买成功后的直播课视频
 * 插入历史记录
 * ********************************************************
 */
namespace App\Http\Controllers\Video;
use App\Model\Video\Videos;
use App\Plugins\Valid\Valid;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use JWTAuth;
class VideoController extends Controller
{

    /* 我的课程(视频列表)
      * 传入参数：：token,
     */
    public function myindex (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'page' => 'require|integer@页码'
        ]);

        //获取用户ID
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;
        $list = DB::table('x2_user_video as A')
//                ->leftJoin('x2_videos as B','A.videoid', '=', 'B.videoid' )
            ->leftJoin('x2_videos as B', function ($join) {
                $join->on('A.videoid', '=', 'B.videoid')
                    ->where('B.is_delet', '=', 0);
            })
            ->leftJoin('x2_video_course as C', 'B.courceid', '=', 'C.courseid')
            ->leftJoin('x2_orders as D','A.orderid','=','D.orderid')      
            ->select('B.videoid', 'B.remoteurl', 'C.coursethumb', 'C.courseusername','B.videoname','B.duration','C.courseprice','B.createtime','B.mp4url', 'C.courseid')
            ->addSelect(DB::raw('if(B.videoid, 0, 1) as is_expired'))
            ->where('A.userid', $userid)
            ->where('A.videotype', 0)
            ->orderBy('D.ordercreatetime','DESC')
            ->paginate(6);
        return $this->succ($request, $list);

    }

    /* 直播课列表
     * 传入参数：token
     */
    public function myliveindex (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'page' => 'require|integer@页码'
        ]);
        //获取用户ID
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        $list = DB::table('x2_user_video as A')
            ->join('x2_video_special as B', 'A.videoid', '=', 'B.vid')
            ->join('x2_user as C', 'A.userid', '=', 'C.userid')
            ->select(  'B.vid','B.vurl', 'C.usertruename','B.vname','B.vintro','B.vprice','B.createtime','B.endtime','B.mp4url', 'B.videohumb')
            ->where('A.userid', $userid)
            ->where('A.videotype', 1)
            ->paginate(6);
        return $this->succ($request, $list);
    }

    /* 缓存历史纪录
     * 传入参数：token
     */
    public function mylib (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'page' => 'require|integer@页码'
        ]);
        //获取用户ID
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        $list = DB::table('x2_videohistory as A')
            ->join('x2_videos as B', 'A.videoid', '=', 'B.videoid')
            ->join('x2_video_course as C', 'B.courceid', '=', 'C.courseid')
            ->select( 'A.videoid','B.remoteurl', 'B.videohumb', 'C.courseusername','B.videoname','B.duration','C.courseprice','A.gettime','B.mp4url')
            ->where('A.userid', $userid)
            ->paginate(6);

        return $this->succ($request, $list);
    }

    /* 练习中心
     * 传入参数：token
     */
    public function mysublist (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'page' => 'require|integer@页码'
        ]);
        //获取用户ID
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        $list = DB::table('x2_questions_sub as A')
            ->join('x2_user as B', 'A.teacherid', '=', 'B.userid')
            ->join('x2_orders as C', 'A.orderid', '=', 'C.orderid')
            ->select( 'A.videourl','B.usertruename','A.usertime','A.teachertime','C.ordersn','C.orderprice','A.videohumb','A.mp4url')
            ->where('A.userid', $userid)
            ->where('is_correcting', 1)
            ->paginate(6);

        return $this->succ($request, $list);
    }


    /* 插入购买成功后的视频
     * 传入参数：courseid 课程ID
     */
    public function create (Request $request, Valid $valid)
    {

        $valid->rule($request, [
            'courseid' => 'require|integer',
            'type'=>'require|integer'
        ]);

        $courseid = $request->input('courseid');
        $type = $request->input('type');
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        //首先判断是否已经有这个课程了，有的话直接返回
        $IsHaveCourse = DB::table('x2_user_video')
                            ->where([
                                ['courseid', $courseid],
                                ['userid', $userid]
                            ]) ->get();

        if(count($IsHaveCourse) >= 1)
        {
            throw new \Exception('已购买过该课程');
        }

        //获取视频列表
        $course = Videos::select('videoid')
            ->where('courceid', $request->input('courseid'))
            ->get();
//       $curl="http://localhost/yijiangtang/admin/index.php?core-api-zhifu&ordersn='654143251155'&ordertitle='45654'&orderprice=100ordercenter='h565444";
//       return  $this->_request($curl);
//       exit;
       // print_r($course);

        if($type==1){
            $detail = DB::table('x2_video_course')
            ->select( 'coursename','courseintro','courseprice')
            ->where('courseid', $courseid)->get();
           // $detail= DB::select('select * from x2_video_course where courseid=? limit 1',[$courseid]);


            if($detail){
                 try{

                    $orderlist=[];
                    $orderlist['courseid'] = $courseid;
                    $orderlist['orderuserid'] = $userid;
                   // $orderlist['videoid'] = '';

                    $orderlist['ordersn'] = time().$userid.$courseid.$type;
                    $orderlist['ordertitle'] = $detail[0]->coursename;
                    $orderlist['orderdescribe'] = $detail[0]->courseintro;
                    $orderlist['ordertype'] = $type;
                    $orderlist['orderprice'] = $detail[0]->courseprice;//应该减去优惠券金额
                    $orderlist['orderfullprice'] = $detail[0]->courseprice;
                    $orderlist['couponsn'] = 30;
                    $orderlist['orderstatus'] = 0;
                    $orderlist['ordercreatetime'] = time();

                    DB::table('x2_orders')->insert($orderlist);
                   // return $this->succ($request);
                }
                catch (\Exception $e) {
                    throw new \Exception('生成错误');
                }

            }else{
                 throw new \Exception('课程已过期');
            }

        }

        //插入视频列表
        if ($course) {
            try{
                $videolist = [];
                $order=DB::select('select orderid from x2_orders order by ordercreatetime desc limit 1');
                foreach($course as $key => $videos) {
                    $videolist[$key]['courseid'] = $courseid;
                    $videolist[$key]['userid'] = $userid;
                    $videolist[$key]['videoid'] = $videos['videoid'];
                    $videolist[$key]['status'] = 1;
                    $videolist[$key]['orderid'] = $order[0]->orderid;
                }

                DB::table('x2_user_video')->insert($videolist);
                return $this->succ($request);
            }
            catch (\Exception $e) {
                throw new \Exception('生成错误');
            }
        }

        return $this->succ($request);
    }
    /* 服务器端请求*/
    public function _request($curl, $https = true, $method = 'GET', $data = null){
		$ch = curl_init(); // 初始化curl
		curl_setopt($ch, CURLOPT_URL, $curl); //设置访问的 URL
		curl_setopt($ch, CURLOPT_HEADER, false); //放弃 URL 的头信息
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，而不直接输出
		if($https){ //判断是否是使用 https 协议
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不做服务器的验证
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //做服务器的证书验证
		}
		if($method == 'POST'){ //是否是 POST 请求
			curl_setopt($ch, CURLOPT_POST, true); //设置为 POST 请求
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置POST的请求数据
		}
		$content = curl_exec($ch); //开始访问指定URL
		curl_close($ch);//关闭 cURL 释放资源
		return $content;
	}
     /*
     * 插入课程用户的评论
     * 传入参数：courseid 课程ID
      *         content  评论内容
     */
    public function createcomment (Request $request, Valid $valid)
    {

        $valid->rule($request, [
            'courseid' => 'require|integer',
            'content'=>'require',
        ]);

        $courseid = $request->input('courseid');
        $content = $request->input('content');
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;


        //插入评论列表


            try{
                $commentlist = [];

                $commentlist['courseid'] = $courseid;
                $commentlist['userid'] = $userid;
                $commentlist['content'] = '"'.$content.'"';
                $commentlist['createtime']=time();

                DB::table('x2_user_comment')->insert($commentlist);
                //DB::insert('insert into x2_user_comment (courseid,userid,content,createtime1) values(?,?,?,?)',$commentlist);
                return $this->succ($request);
            }
            catch (\Exception $e) {

                throw new \Exception('生成错误');
            }


    }
      /* 练习中心
     * 传入参数：token
     */
    public function listcomment (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'courseid' => 'require|integer'
        ]);
        //获取用户ID
//        $user = JWTAuth::parseToken()->authenticate();
//        $userid = $user->userid;
        $courseid = $request->input('courseid');
        $list = DB::table('x2_user_comment as A')
            ->join('x2_user as B', 'A.userid', '=', 'B.userid')
            ->select( 'A.content','A.createtime','B.username')
            ->where('A.courseid', $courseid)
            ->paginate(6);

        return $this->succ($request, $list);
    }

    /* 插入购买成功后的直播课视频
     * 传入参数：vid 直播课ID
     */
    public function createlive (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'vid' => 'require|integer',
        ]);
        //ID
        $vid = $request->input('vid');
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        //首先判断是否已经有这个视频了，有的话直接返回
        $IsHaveCourse = DB::table('x2_user_video')
            ->whereExists(function  ($query) use($vid,$user) {
                $query ->where('videoid', '=',$vid)->where('userid', '=',$user)->where('videotype', '=',0);
            }) ->get();
        If(count($IsHaveCourse)>=1)
        {
            throw new \Exception('已购买过该课程');
        }
        //获取视频列表
       $course = Videos::select('videoid')
            ->where('courceid', $request->input('courseid'))
            ->get();
        //插入视频列表
        if ($course) {
            try{
                $videolist = [];

                $videolist['courseid'] = 0;
                $videolist['userid'] = $userid;
                $videolist['videoid'] = $vid;
                $videolist['status'] = 1;

                DB::table('x2_user_video')->insert($videolist);
                return $this->succ($request);
            }
            catch (\Exception $e) {
                throw new \Exception('生成错误');
            }
        }

        return $this->succ($request);
    }

    /* 插入历史记录
     * 传入参数：vid 直播课ID
     */
    public function createlib (Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'videoid' => 'require|integer',
        ]);
        $videoid = $request->input('videoid');
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        DB::table('x2_videohistory')->insert(
            ['userid' => $userid, 'videoid' => $videoid]
        );
        return $this->succ($request);
    }

}
