<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Plugins\Valid\Valid;
use App\User;
use JWTAuth;

class PwdController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        //
    }

	/**
	 * 修改密码
	 *
	 */
    public function retrieve (Request $request, Valid $valid) {
		$valid->rule($request, [
        	'old_userpassword' => 'require@旧密码',
        	'new_userpassword' => 'require@新密码'
        ]);
		$old_userpassword = md5($request->input('old_userpassword'));
		$new_userpassword = md5($request->input('new_userpassword'));
		if($new_userpassword == $old_userpassword) {
			throw new \Exception('新密码不能与旧密码一样');
		}
		$user = JWTAuth::parseToken()->authenticate();
		$userpassword = $user->userpassword;
		
		if ($old_userpassword != $userpassword) {
			throw new \Exception('原密码不正确');
		} else {
			$user->userpassword = $new_userpassword;
			$user->save();
			return $this->succ($request);
		}
    }

	/**
	 * 找回密码
	 */
	public function getBack (Request $request, Valid $valid) {
		$valid->rule($request, [
			'username' => 'require|mobile@手机号',
			'userpassword' => 'require@密码'
		]);
		$user = User::where('username', $request->input('username'))->first();
		if($user) {
			$user->userpassword = md5($request->input('userpassword'));
			$user->save();
			$token = JWTAuth::fromUser($user);
			return $this->succ($request, compact('token'));
		} else {
			throw new \Exception('还没有注册');
		}
	}

}