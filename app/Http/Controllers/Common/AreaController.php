<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Common\Area;

class AreaController extends Controller
{
    public function index (Request $request) {

		$keytype = $request->input('keytype');

		if(isset($keytype) && $keytype == 2) {
			$list = Area::where('arealevel', 0)->get();
		} else {
			$list = Area::select('group')->groupBy('group')->get();
			$list->each(function ($item, $key) {
				$group = $item->group;
				$children = Area::where('group', $group)->get();
				$item->children = $children;
			});
		}
		return $this->succ($request, $list);
    }
}
