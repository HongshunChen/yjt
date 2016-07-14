<?php

namespace App\Model\Exam;

use Illuminate\Database\Eloquent\Model;

class QuestionsSub extends Model
{
    protected $table = 'x2_questions_sub';
    protected $primaryKey = 'subid';

    protected $fillable = [
        'pid', 'userid', 'subname', 'questionid', 'is_correcting', 'subtype', 'subtitle', 'answer_type',
        'answer_text', 'answer_img', 'teacherid', 'orderid', 'videourl', 'videoid', 'usertime', 'teachertime'
    ];

    public $timestamps = false;

}
