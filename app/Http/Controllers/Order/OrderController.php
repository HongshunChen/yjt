<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plugins\Valid\Valid;

class OrderController extends Controller
{
    /**
     * 购买回调接口
     */
    public function orderCallback (Request $request, Valid $valid) {
        $valid->rule($request, [
            'keytype' => 'require|integer@订单类型',
            'keyid' => 'require|integer@关联主键id'
        ]);

        $this->succ($request);

    }
}
