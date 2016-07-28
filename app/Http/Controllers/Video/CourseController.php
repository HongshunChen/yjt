<?php

namespace App\Http\Controllers\Video;

use App\Model\Video\Course;
use App\Model\Video\CourseType;
use App\Plugins\Valid\Valid;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CourseController extends Controller
{
    /* 课程类别
     * 传入参数：无
     * 传出参数：分类ID，父类ID，分类名称
     */
    public function getcate(Request $request)
    {
        //获取顶级分类
        $datalist = CourseType::select('catid', 'catname')->where('catpid', '=', 0)->get();
        //获取二级分类
        $datalist->each(function ($item, $key) {
            $catid = $item->catid;
            $list = CourseType::where('catpid', $catid)->get();
            $item->list = $list;
        });
        //返回数据列表
        return $this->succ($request, $datalist);
    }

    /** 课程列表
    * 传入参数：c（可选） n（可选） k（可选）
    * 传出参数：ID,课程名称，主讲老师，价格，图片
    * mysql: SELECT t.courseid, t.coursename,t.courseusername,t.courseprice,t.coursethumb,
    * count(i.videoid) reminderCount
    * from x2_video_course t,x2_videos i
    * WHERE t.courseid=i.courceid
    * GROUP BY t.courseid
    *
    */
    public function index(Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'page' => 'require|integer@页码'
        ]);
        $cid = $request->input('c');
        $nid = $request->input('n');
        $kid = $request->input('k');

        if ($request->input('token')) {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->userid;
        } else {
            $user_id = 0;
        }

        //*************************************
        $list = DB::table('x2_video_course as A')
            ->join('x2_videos as B', 'A.courseid', '=', 'B.courceid')
            ->leftJoin('x2_user_video as C', 'A.courseid', '=', 'C.courseid')
            ->leftJoin('x2_user_video as D', function($join) use ($user_id) {
                $join->on('A.courseid', '=', 'D.courseid')
                    ->where('D.userid', '=', $user_id);
            })
            ->select('A.courseid', 'A.coursename', 'A.courseusername', 'A.courseprice', 'A.coursethumb')
            ->addSelect(DB::raw('count(B.videoid) as user_count'))
            ->addSelect(DB::raw('if(count(D.itemid), 1, 0) as is_buy'))
            ->where(function ($query) use ($cid) {
                if (isset($cid) && !empty($cid)) {
                    $query->where('A.courseify1', $cid);
                }
            })->where(function ($query) use ($nid) {
                if (isset($nid) && !empty($nid)) {
                    $query->where('A.courseify2', $nid);
                }
            })->where(function ($query) use ($kid) {
                if (isset($kid) && !empty($kid)) {
                    $query->where('A.courseify3', $kid);
                }
            })
            ->orderBy('A.coursetime','DESC')
            ->groupBy('A.courseid')
            ->paginate(5);
   
        return $this->succ($request, $list);
    }

    /* 课程详情 Course
     * 传入参数:课程编号 courseid
     * 传出参数：课程介绍 ，课程内容，名师介绍(图片/名字/简介)
     */
    public function detail(Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'courseid' => 'require|integer',
        ]);
        //课程ID
        $courseid = $request->input('courseid');

        $detail = DB::table('x2_video_course as A')
           // ->join('x2_user as B', 'A.teacherid', '=', 'B.userid')
            ->select('A.courseid', 'A.courseintro as courseintro', 'A.contentintro', 'A.coursename', 'A.courseprice', 'A.coursethumb','A.courseatract','A.cpaidcontent','A.courseusername as teachername','A.teacherintro')
           // ->addSelect('B.userid as teacherid', 'B.photo as teacherthumb', 'B.usertruename as teachername', 'A.teacherintro')
            ->where('A.courseid', $courseid)
            ->first();

        $detail->courseintro = htmlspecialchars_decode($detail->courseintro);
        $detail->contentintro = htmlspecialchars_decode($detail->contentintro);
        $detail->teacherintro = htmlspecialchars_decode($detail->teacherintro);

        return $this->succ($request, $detail);
    }
}