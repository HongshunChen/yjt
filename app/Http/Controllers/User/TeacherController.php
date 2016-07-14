<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class TeacherController extends Controller
{
    /**
     * 名师列表
     */
    public function index (Request $request) {
        $teachers = DB::table('x2_user')
                        ->select('userid', 'username', 'photo', 'usertruename', 'teacher_subjects')
                        ->where('usergroupid', '1')
                        ->orderBy(DB::raw('rand()'))
                        ->take(3)
                        ->get();

        foreach ($teachers as $key => $teacher) {
            $teachers[$key]->title = '资深培训师';
            $teachers[$key]->score = rand(90,100)/10;
        }

        return $this->succ($request, $teachers);

    }
}
