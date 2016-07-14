<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\User;

class RegMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		//检查手机号是否已注册
		$username = $request->input('username');
		$count = User::where('username', '=', $username)->count();

		if ($count > 0) {
			throw new \Exception('手机号已注册');
		} else {
			$request['userpassword'] = md5($request->input('userpassword'));
	    	$request['userregtime'] = Carbon::now()->timestamp;
	    	$request['userregip'] = $request->getClientIp();
	        return $next($request);
		}
    }
}
