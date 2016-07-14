<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Responsities\StatisResponsity;

class StatisController extends Controller
{
    /**
     * 课程人数统计
     */
    public function members (Request $request, StatisResponsity $statis) {
        //视频课程
        $video = 0;
        //直播课程
        $live = 0;
        //客观题课程
        $objective = $statis->objectiveMembers();
        //主观题课程
        $subjective = $statis->subjectiveMembers();
        //全真模拟
        $simulate = $statis->simulateMembers();

        return $this->succ($request, compact('video', 'live', 'objective', 'subjective', 'simulate'));

    }


}
