<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Exam\Questype;
use App\Plugins\Valid\Valid;

class QuestypeController extends Controller
{
    public function index (Request $request, Valid $valid) {
    	$valid->rule($request, [
    		'type' => 'require|integer@获取类型'
    	]);
		
		$type = $request->input('type');
		if ($type > 0) {
			$list = Questype::where('type', $type)->get();
		} else {
			$list = Questype::get();
		}
    	
		return $this->succ($request, $list);
    }
}
