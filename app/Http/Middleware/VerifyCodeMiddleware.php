<?php

namespace App\Http\Middleware;

use Closure;
use App\Plugins\Message\Message;

class VerifyCodeMiddleware
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
    	$message = new Message;
    	$verifycode = $request->input('verifycode');
		$mobile = $request->input('username');
		
		$is_valid = $message->checkCode($request, $verifycode, $mobile);
		
		if (!$is_valid) {
			throw new \Exception('验证码不正确');
		}
		
        return $next($request);
    }
}
