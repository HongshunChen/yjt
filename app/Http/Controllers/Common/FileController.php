<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Responsities\FileResponsity;


class FileController extends Controller
{
    public function test(Request $request, FileResponsity $file_repo) {
        $url = $file_repo->upload($request, 'my_file');
        dd($url);
    }
}
