<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Plugins\Valid\Valid;
//use Illuminate\Http\Response;
use App\User;
use JWTAuth;

class InfoController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        //
    }
    
    public function index (Request $request) {
    	
		$user = JWTAuth::parseToken()->authenticate();
    	
    	return $this->succ($request, $user);
		
    }

    public function update (Request $request, Valid $valid) {
        $valid->rule ($request, [
            'nickname' => 'require@用户昵称'
        ]);

        try {
            $user = JWTAuth::parseToken()->authenticate();
            $user->nickname = $request->input('nickname');
            $user->save();
        } catch (\Exception $e) {
            throw new \Exception('修改失败,稍后重试');
        }

        return $this->succ($request);

    }
       public function finishUserInfo (Request $request, Valid $valid) {
        $valid->rule ($request, [
            'address' => 'require@地址',
            'qq' => 'number@qq'
        ]);

        try {
            $user = JWTAuth::parseToken()->authenticate();
            $user->qq = $request->input('qq');
            $user->weixin = $request->input('weixin');
            $user->address= $request->input('address');
            $user->save();
             
        } catch (\Exception $e) {
            throw new \Exception('完善失败,稍后重试');
        }

        return $this->succ($request);

    }
}