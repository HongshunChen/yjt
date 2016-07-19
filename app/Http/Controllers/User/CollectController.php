<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plugins\Valid\Valid;
use JWTAuth;
use DB;

class CollectController extends Controller
{
    // 收藏/取消收藏
    public function update (Request $request, Valid $valid) {
        $valid->rule($request, [
            'questionid' => 'require|integer@收藏id'
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        $favor = DB::table('x2_favor')
                    ->where([
                        ['favoruserid', $userid],
                        ['favorquestionid', $request->input('questionid')]
                    ])
                    ->first();
        if($favor) {
            $favorid = $favor->favorid;
            DB::table('x2_favor')->where('favorid', $favorid)->delete();
            $tips = '取消收藏';
        } else {
            DB::table('x2_favor')
                ->insert([
                    'favoruserid' => $userid,
                    'favorquestionid' => $request->input('questionid'),
                    'favortime' => time()
                ]);
            $tips = '收藏成功';
        }

        return $this->succ($request, compact('tips'));

    }

    /**
     * 收藏列表
     */
    public function getList (Request $request, Valid $valid) {
        $valid->rule($request, [
            'questiontype' => 'require|integer@类型',
            'page' => 'require|integer@页码'
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        $favor_list = DB::table('x2_favor as A')
                        ->select('A.favorid', 'B.question', 'B.questiontype', 'B.questionselect')
                        ->addSelect('B.questionanswer', 'B.questiondescribe')
                        ->join('x2_questions as B', 'A.favorquestionid', '=', 'B.questionid')
                        ->where([
                            ['A.favoruserid', $userid],
                            ['B.questiontype', $request->input('questiontype')]
                        ])
                        ->paginate(10);
        foreach($favor_list as $key => $item) {
            $favor_list[$key]->questionselect = htmlspecialchars_decode($item->questionselect);
        }

        return $this->succ($request,page_helper($favor_list));

    }

    /**
     * 收藏详情
     */
    public function getOne (Request $request, Valid $valid) {
        $valid->rule($request, [
            'favorid' => 'require|integer@id'
        ]);

        $favor = DB::table('x2_favor as A')
                        ->select('A.favorid', 'B.questionid','B.question', 'B.questiontype', 'B.questionselect')
                        ->addSelect('B.questionanswer', 'B.questiondescribe')
                        ->join('x2_questions as B', 'A.favorquestionid', '=', 'B.questionid')
                        ->where('A.favorid', $request->input('favorid'))
                        ->first();

        if ($favor) {
            $favor->questionselect = htmlspecialchars_decode($favor->questionselect);
            return $this->succ($request, $favor);
        } else {
            throw new \Exception('收藏不存在');
        }


    }


}
