<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InitController extends Controller
{
    public function index (Request $request) {
    	$info = [
    		'file_root' => asset('')
    	];
		return $this->succ($request, $info);
    }
}
