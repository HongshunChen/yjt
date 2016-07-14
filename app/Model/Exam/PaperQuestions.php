<?php

namespace App\Model\Exam;

use Illuminate\Database\Eloquent\Model;

class PaperQuestions extends Model
{
    protected $table = 'x2_paper_questions';

    public $timestamps = false;

    protected $fillable = [
        'paper_id', 'questionid', 'score', 'answered', 'question_no', 'is_answered'
    ];

    public function question () {
        return $this->belongsTo('App\Model\Exam\Questions', 'questionid', 'questionid');
    }

    public function paper () {
        return $this->belongsTo('App\Model\Exam\Paper');
    }

}
