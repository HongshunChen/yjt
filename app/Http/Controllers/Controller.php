<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
	
	//jsonp
    public function succ($request, $data='', $code = '0') {

    	if ($data instanceof Model) {
    		$data = [$data->toArray()];
    	}
    	$resData = array(
    		'status' => '1',
    		'data' => $data,
    		'code' => $code
    	);
    	
    	$headers = array(
    			'Content-Type' => 'application/json; charset=utf-8'
    	);
    	
    	return response() -> json($resData, 200, $headers, JSON_UNESCAPED_UNICODE)
    					  -> setCallback($request->input('callback'));
    	
    }
	
}
