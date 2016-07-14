<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/21
 * Time: 10:09
 */

namespace App\Responsities;

use Storage;

class FileResponsity {
    /**
     * base64 文件上传
     */
    public function saveImgBase64 ($content) {

        $content_arr = explode(',', $content);
        $img_content = base64_decode($content_arr[1]);

//        $dir = base_path() . '\public';
//        $dir_relative = '\uploads\\' . date('Y') . '\\' . date('m') . '\\';
        $year = date('Y');
        $month = date('m');
        $file = time() . rand(1000, 9999);
        $savePath = $year . '/' . $month . '/' . $file;

//        $dir_absolute = $dir . $dir_relative;


        Storage::put($savePath, $img_content);

        return $savePath;
    }

    /**
     * form-data文件流上传
     */
    public function upload ($request, $file_name, $dir = '') {

        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile($file_name)){
            throw new \Exception('文件不存在');
        }
        $file = $request->file($file_name);
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            throw new \Exception('文件上传出错！');
        }

        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $year = date('Y');
        $month = date('m');
        $savePath = $dir . '/' . $year . '/' . $month . '/' . $newFileName;
        $res = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );

        if(!Storage::exists($savePath)){
            throw new \Exception('上传失败');
        }
        $url = Storage::url($savePath);
        return $url;

    }

}