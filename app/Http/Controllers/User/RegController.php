<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Plugins\Valid\Valid;
//use Illuminate\Http\Response;
use App\User;
use JWTAuth;

class RegController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        //
    }
    
    public function store (Request $request, Valid $valid) {
    	
		$valid->rule($request, [
			'username' => 'require|mobile@手机号',
			'userpassword' => 'require@密码',
			'verifycode' => 'require@验证码'
		]);
    	$input = $request->input();
		$input['nickname'] = $input['username'];
		$input['usergroupid'] = 8;
    	$user = User::create($input);
		if ($user) {
			$token = JWTAuth::fromUser($user);
			return $this->succ($request, compact('token'));
		} else {
			throw new \Exception('注册失败');
		}

    }
    
}