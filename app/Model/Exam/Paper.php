<?php

namespace App\Model\Exam;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table = 'x2_paper';
	
	protected $fillable = [
		'userid', 'submit_at', 'scored', 'did_num', 'updated_at', 'created_at', 'keytype'
	];
	
}
