<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Plugins\Valid\Valid;
//use Illuminate\Http\Response;
use App\User;
use JWTAuth;

class LoginController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        //
    }
    
    public function index (Request $request, Valid $valid) {
    	
		$valid->rule($request, [
			'username' => 'require|mobile@手机号',
			'userpassword' => 'require@密码'
		]);
    	
		$username = $request->input('username');
		$userpassword = md5($request->input('userpassword'));
		
		$user = User::where('username', '=', $username)
					  ->where('userpassword', '=', $userpassword)
					  ->first();
		
		if ($user == null) {
			throw new \Exception('用户名或密码错误');
		} else {
			$token = JWTAuth::fromUser($user);
                        $user->userlogtime = time();
                        $user->save();
	    	        return $this->succ($request, compact('token'));
		}
    }
    
}