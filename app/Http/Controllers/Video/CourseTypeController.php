<?php

namespace App\Http\Controllers\Video;
use App\Model\Video\CourseType;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseTypeController extends Controller
{
    /* 课程类别
       * 传入参数：无
       * 传出参数：分类ID，父类ID，分类名称
      */
    public function index (Request $request)
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
}