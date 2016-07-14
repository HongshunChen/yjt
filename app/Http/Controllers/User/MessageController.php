<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Plugins\Valid\Valid;
use App\Plugins\Message\Message;
//use Illuminate\Http\Response;
use App\User;

class MessageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        //
    }
    
    public function send (Request $request, Valid $valid, Message $message) {
    	
		$valid->rule($request, [
			'username' => 'require|mobile@手机号',
		]);
		
		$username = $request->input('username');		
		$message->sendCode($request, $username);
		
    	return $this->succ($request);
    }
    
}