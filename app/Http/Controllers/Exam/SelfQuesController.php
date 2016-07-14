<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Responsities\FileResponsity;
use App\Plugins\Valid\Valid;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Responsities\SelfQuesResponsity;

class SelfQuesController extends Controller
{
    /**
     * 自备题上传
     * @params int question_type 上传方式, 1: 上传文本, 2: 上传图片(base64方式), 3: 上传图片, 以form数据流方式
     * @params int answer_type 上传方式, 1: 上传文本, 2: 上传图片(base64方式), 3: 上传图片, 以form数据流方式
     *
     */
    public function upload(Request $request, Valid $valid, FileResponsity $file, SelfQuesResponsity $self)
    {
        $valid->rule($request, [
            'question_type' => 'require|integer@问题上传方式',
            'answer_type' => 'require|integer@答案上传方式',
        ]);

        $question_type = $request->input('question_type');
        $answer_type = $request->input('answer_type');

//        try {
            switch ($question_type) {
                case 1:
                    $question = $request->input('question');
                    break;
                case 2:
                    $question = $file->saveImgBase64($request->input('question'));
                    break;
                case 3:
                    $question = $file->upload($request, 'question_file');
                    break;
                default:
                    throw new \Exception('问题上传方式错误');
                    break;
            }

            switch ($answer_type) {
                case 1:
                    $answer = $request->input('answer');
                    break;
                case 2:
                    $answer = $file->saveImgBase64($request->input('answer'));
                    break;
                case 3:
                    $answer = $file->upload($request, 'answer_file');
                    break;
                default:
                    throw new \Exception('答案上传方式错误');
                    break;
            }
            $user = JWTAuth::parseToken()->authenticate();
            $userid = $user->userid;

            if(!isset($question) || empty($question)) {
                throw new \Exception('问题不能为空');
            }

            if(!isset($answer) || empty($answer)) {
                throw new \Exception('答案不能为空');
            }

            $self->store($userid, $question_type, $question, $answer_type, $answer);

//        } catch (\Exception $e) {
//            throw new \Exception('上传错误');
//        }

        return $this->succ($request);

    }
}



