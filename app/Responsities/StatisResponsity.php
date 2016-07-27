<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/21
 * Time: 15:36
 */
namespace App\Responsities;

use DB;

class StatisResponsity {

    //视频参与人数
    public function videoMembers () {
	$sta = DB::table('x2_videohistory')
            ->select(DB::raw('count(vhid) as total_count'))
            ->first();
        return $sta ? $sta->total_count : 0;


    }
    //直播参与人数
    public function liveMembers () {
	$sta = DB::table('x2_user')
            ->select(DB::raw('count(userid) as total_count'))
	   ->first();
        return $sta ? $sta->total_count : 0;

    }
    //主观题参与人数
    public function subjectiveMembers () {
        $sta = DB::table('x2_paper_questions as A')
                    ->select(DB::raw('count(A.id) as total_count'))
                    ->join('x2_paper as B', 'A.paper_id', '=', 'B.id')
                    ->join('x2_questions as C', 'A.questionid', '=', 'C.questionid')
                    ->where([
                        ['C.questiontype', '>', 3],
                        ['B.keytype', 1]
                    ])
                    ->groupBy('A.questionid', 'B.userid')
                    ->first();
        return $sta ? $sta->total_count : 0;
    }
    //客观题参与人数
    public function objectiveMembers () {
        $sta = DB::table('x2_paper_questions as A')
                    ->select(DB::raw('count(A.id) as total_count'))
                    ->join('x2_paper as B', 'A.paper_id', '=', 'B.id')
                    ->join('x2_questions as C', 'A.questionid', '=', 'C.questionid')
                    ->where([
                        ['C.questiontype', '>', 3],
                        ['B.keytype', 1]
                    ])
                    ->groupBy('A.questionid', 'B.userid')
                    ->first();
        return $sta ? $sta->total_count : 0;
    }
    //全真模拟参与人数
    public function simulateMembers () {
        $sta = DB::table('x2_paper')
            ->select(DB::raw('count(id) as total_count'))
            ->where('keytype', 2)
            ->groupBy('userid')
            ->first();
        return $sta ? $sta->total_count : 0;
    }
}