<?php

namespace App\Http\Controllers\Video;

use App\Model\Video\CourseType;
use App\Model\Video\VideoSpecials;
use App\Plugins\Valid\Valid;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/* 直播课程列表 Course
* 传入参数：courseify1（可选） courseify2（可选） courseify3（可选）
* 传出参数：ID,课程名称，主讲老师，价格，图片，课时
*/
class CourseLiveController extends Controller
{
    public function index(Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'page' => 'require|integer@页码'
        ]);
        $cid = $request->input('c');
        $nid = $request->input('n');
        $kid = $request->input('k');
        $list = DB::table('x2_video_special as A')
            ->join('x2_user as B', 'A.uid', '=', 'B.userid')
          
            ->select('A.vid', 'A.vurl', 'B.usertruename', 'A.vname','A.vintro','A.vteachername','A.vatract','A.vteacherintro', 'A.videohumb', DB::raw('round(A.vprice,0) as  vprice'), 'A.createtime', 'A.endtime','A.mp4url')
            ->where(function ($query) use ($cid) {
                if (isset($cid) && !empty($cid)) {
                    $query->where('courseify1', $cid);
                }
            })->where(function ($query) use ($nid) {
                if (isset($nid) && !empty($nid)) {
                    $query->where('courseify2', $nid);
                }
            })->where(function ($query) use ($kid) {
                if (isset($kid) && !empty($kid)) {
                    $query->where('courseify3', $kid);
                }
            })
            ->orderBy('A.createtime','DESC')
            ->paginate(6);


        return $this->succ($request, $list);
    }

    /* 课程详情 Course
     * 传入参数:直播视频编号 vid
     * 传出参数：课程介绍 ，课程内容，名师介绍(图片/名字/简介)
     */
    public function detail(Request $request, Valid $valid)
    {
        $valid->rule($request, [
            'vid' => 'require|integer',
        ]);
        $vid = $request->input('vid');
        $paidstatus=DB::table('x2_orders')->select('orderid')->where('videoid',$vid)->get();
        if($paidstatus){
             $detail = DB::table('x2_video_special as A')
              ->leftJoin('x2_orders as C','C.videoid','=','A.vid')
            //->join('x2_user as B', 'A.uid', '=', 'B.userid')
            ->select('A.vid', 'A.vteachername as teachername','A.vteacherintro as teacherintro','A.vatract','A.vpaidcontent','A.vintro as vintro', 'A.vcontent', 'A.vname',DB::raw('round(A.vprice,0) as  vprice'),'A.vurl', 'A.videohumb as coursethumb','A.mp4url','A.endtime')
          // ->addSelect('B.userid as teacherid','B.photo as teacherthumb','B.usertruename as teachername','B.teacher_subjects as teacherintro')
            ->where('A.vid', $vid)
            ->first();
        }else{
             $detail = DB::table('x2_video_special as A')
              ->leftJoin('x2_orders as C','C.videoid','=','A.vid')
            //->join('x2_user as B', 'A.uid', '=', 'B.userid')
            ->select('A.vid', 'A.vteachername as teachername','A.vteacherintro as teacherintro','A.vatract','A.vintro as vintro', 'A.vcontent', 'A.vname',DB::raw('round(A.vprice,0) as  vprice'),'A.vurl', 'A.videohumb as coursethumb','A.mp4url','A.endtime')
          // ->addSelect('B.userid as teacherid','B.photo as teacherthumb','B.usertruename as teachername','B.teacher_subjects as teacherintro')
            ->where('A.vid', $vid)
            ->first();
        }
       
   
        $detail->vintro = htmlspecialchars_decode($detail->vintro);
        $detail->vcontent = htmlspecialchars_decode($detail->vcontent);
        $detail->teacherintro = htmlspecialchars_decode($detail->teacherintro);
        return $this->succ($request, $detail);
    }
}