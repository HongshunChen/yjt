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
            ->select('B.videoid', 'B.remoteurl', 'C.coursethumb', 'C.courseusername','B.videoname','B.duration','C.courseprice','B.createtime','B.mp4url', 'C.courseid')
            ->addSelect(DB::raw('if(B.videoid, 0, 1) as is_expired'))
            ->where('A.userid', $userid)
            ->where('A.videotype', 0)
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
        ]);
        //课程ID
        $courseid = $request->input('courseid');
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        //首先判断是否已经有这个课程了，有的话直接返回
        $IsHaveCourse = DB::table('x2_user_video')
                            ->where([
                                ['courseid', $courseid],
                                ['userid', $userid]
                            ])
                             ->get();
        If(count($IsHaveCourse) >= 1)
        {
            throw new \Exception('已购买过该视频');
        }
        //获取视频列表
        $course = Videos::select('videoid')
            ->where('courceid', $request->input('courseid'))
            ->get();
        //插入视频列表
        if ($course) {
            try{
                $videolist = [];
                foreach($course as $key => $videos) {
                    $videolist[$key]['courseid'] = $courseid;
                    $videolist[$key]['userid'] = $userid;
                    $videolist[$key]['videoid'] = $videos['videoid'];
                    $videolist[$key]['status'] = 1;
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
        If(count($IsHaveCourse)<1)
        {
            return $this->succ($request);
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