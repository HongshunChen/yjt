<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/21
 * Time: 11:28
 */
namespace App\Responsities;

use App\Model\Exam\QuestionsSub;
class SelfQuesResponsity {
    /**
     * 保存
     */
    public function store ($userid, $question_type, $question, $answer_type, $answer) {

        $question_sub = QuestionsSub::create();

        $question_sub->questionid = 0;
        $question_sub->userid = $userid;
        $question_sub->subname = $question;

        if ($answer_type == 1) {
            $question_sub->answer_type = 1;
            $question_sub->answer_text = $answer;
        } else {
            $question_sub->answer_type = 2;
            $question_sub->answer_img = $answer;
        }

        $question_sub->save();

        return;

    }
}