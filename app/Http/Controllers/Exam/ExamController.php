<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plugins\Valid\Valid;
use App\Model\Exam\Questions;
use App\Model\Exam\PaperQuestions;
use App\Model\Exam\QuestionsSub;
use JWTAuth;
use DB;
use App\Model\Exam\Paper;
use Carbon\Carbon;
use App\Responsities\CouponResponsity;
use App\Responsities\FileResponsity;

class ExamController extends Controller
{
	
	/**
	 * 创建试卷
	 *
	 * @param int keytype 试卷类型, 1: 普通练习, 2: 全真模拟
	 * @param int questiontype 练习类型, 1: 单选, 2: 多选,... 全真模拟传0
	 * @param int areaid 地区id, 全真模拟时用到
	 *
	 * @return int paper_id 试卷主键id
	 * @return int keytype 试题类型, 1: 普通联系, 2: 全真模拟
	 * @return int questiontype 联系类型, 0: 全真模拟, 1: 单选, 2: 多选, 3. 判断 ...
	 * @return int total_count 试题总数
	 * @return int total_score 总分
	 * @return timestamp created_at 试卷生成时间
	 *
	 * @err 生成试卷错误
	 */
	public function create (Request $request, Valid $valid) {
		$valid->rule($request, [
			'keytype' => 'require|integer@试卷类型',
			'questid' => 'require|integer@练习类型',
    	]);

		$areaname = $request->input('areaname');

		if(isset($areaname) && !empty($areaname) && $areaname != 'undefined') {
			$areaid = $this->getAreaid($request->input('areaname'));
		}

		//获取试题
		$keytype = $request->input('keytype');
		$questid = $request->input('questid');
		switch ($keytype) {
			case 1: //普通练习
				$exams = $this->_getQuestions($questid, 30);
				break;
			case 2: //全真模拟
				if (!isset($areaid)) {
					$areaid = 1;
				}
				$exams = $this->createSimulate($areaid);
				break;
			default:
				throw new \Exception('试卷类型错误');
				break;
		}
		if ($exams) {
			$user = JWTAuth::parseToken()->authenticate();
			$userid = $user->userid;
			try{
				$paper_id = 0;
				$created_at = '';
				//并卵的事务处理
				DB::transaction(function () use ($exams, $userid, $keytype, &$paper_id , &$created_at) {
					$paper = Paper::create(['userid' => $userid, 'keytype' => $keytype]);
					$paper_id = $paper->id;
					$created_at = $paper->created_at;
					$this->_saveQuestions($paper_id, $exams);
				});

				$data['paper_id'] = $paper_id;
				$data['keytype'] = $keytype;
				$data['questid'] = $questid;
				$data['total_count'] = count($exams);
				$data['total_score'] = '100分';
				$data['created_at'] = $created_at->toDateTimeString();

				return $this->succ($request, $data);

			} catch (\Exception $e) {
				throw new \Exception('生成试卷错误');
			}
		} else {
			throw new \Exception('没有试卷内容');
		}
	}

	/**
	 *  生成全真模拟试卷
	 *  单选, 多选, 判断, 主观题
	 */
	protected function createSimulate ($areaid) {
		$radio_list = $this->_getQuestions(1, config('yjt.simulate.radio_num'), $areaid);
		$multiple_list = $this->_getQuestions(2, config('yjt.simulate.multiple_num'), $areaid);
		$judgement_list = $this->_getQuestions(3, config('yjt.simulate.judgement_num'), $areaid);
		$subject_list = $this->createSubject(config('yjt.simulate.subject_num'), $areaid);
		$data = array_merge($radio_list, $multiple_list, $judgement_list, $subject_list);
		return $data;

	}

	/**
	 * 生成主观题
	 */
	protected function createSubject ($num, $areaid) {
		$subject_list = Questions::select('questionid', 'questiontype', 'question', 'questionselect')
									->addSelect('questionselectnumber', 'questiondescribe')
									->where('questiontype', '>', 3)
									->when($areaid>1, function ($query) use ($areaid) {
										return $query->where('questionsarea', $areaid);
									})
									->take($num)
									->get();

		return $subject_list->toArray();
	}
	
	/**
	 * 获取试题
	 *
	 * @param int paper_id 试卷主键id
	 * @param int question_no 试卷题号
	 *
	 * @return int id 试卷对应试题的主键id
	 * @return string question 题目
	 * @return string questionselect 选项
	 * @return int questionselectnumber 选项个数
	 * @return string answered 考生填写的答案
	 * @return int questiontype 试题类型
	 * @return int prev_no 上一题题号,prev_no = 0 时表示没有上一题了
	 * @return int next_no 下一题题号, next_no = 0 时表示没有下一题了
	 */
	public function getOne(Request $request, Valid $valid) {
		$valid->rule($request, [
			'paper_id' => 'require|integer@试卷',
			'question_no' => 'require|integer'
		]);
		
		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;
		
		$question_no = $request->input('question_no');
		
		$question = DB::table('x2_paper_questions as A')
					 	->join('x2_paper as B', 'A.paper_id', '=', 'B.id')
					  	->join('x2_questions as C', 'A.questionid', '=', 'C.questionid')
						->leftJoin('x2_favor as D', 'C.questionid', '=', 'D.favorquestionid')
					 	->select('A.id', 'A.paper_id', 'C.question', 'C.questionselect', 'C.questionselectnumber', 'A.question_no')
						->addSelect('C.questiondescribe', 'A.answered', 'C.questiontype', 'C.questionid')
						->addSelect(DB::raw('if(D.favorid, 1, 0) as is_favor'))
						->addSelect(DB::raw('if((A.question_no-1)>=0, A.question_no-1, 0) as prev'))
						->addSelect(DB::raw('if((A.question_no+1)<=30, A.question_no+1, 0) as next'))
					 	->where('B.userid', $userid)
					  	->where('A.paper_id', $request->input('paper_id'))
					  	->where('A.question_no', $question_no)
					  	->first();
		if($question) {
			$question->questionselect = htmlspecialchars_decode($question->questionselect);
			$question->question = htmlspecialchars_decode($question->question);
			return $this->succ($request, $question);
		} else {
			throw new \Exception('试题不存在');
		}
	}
	
	/**
	 * 提交单条试题
	 *
	 * @paprams int paper_question_id 试卷对应试题的主键id
	 * @paprams int questiontype 试题类型
	 * @paprams int answertype 答案类型, 1: 文本答案, 2: 图片答案
	 * @paprams int answered 答案, answertype=1时, 为文本, answertype为2时为图片地址
	 */
	public function submitOne (Request $request, Valid $valid, FileResponsity $file) {
		$valid->rule($request, [
			'paper_question_id' => 'require|integer@试题',
			'answertype' => 'require|integer@答案类型',
//			'answered' => 'require@答案'
		]);
		
		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;

		$paper_question = PaperQuestions::with(['paper' => function ($query) use ($userid) {
										return $query->where('userid', $userid);
									}])
									->where('id', $request->input('paper_question_id'))
									->first();

		$answertype = $request->input('answertype');
		switch ($answertype) {
			case 1:
				$answered = $request->input('answered');
				break;
			case 2:
				$answered = $file->saveImgBase64($request->input('answered'));
				break;
			case 3:
				$answered = $file->upload($request, 'answer_file');
				break;
			default:
				throw new \Exception('上传方式不正确');
				break;
		}

		if(!isset($answered) || empty($answered)) {
			throw new \Exception('答案不能为空');
		}

		$paper_question->answer_type = $answertype;
		$paper_question->answered = $answered;
		$paper_question->is_answered = 1;

		$res = $paper_question->save();

		$question = $paper_question->question;
		$questiontype = $question->questiontype;
		if($questiontype > 3) {//主观题答案, 存到主观题表
			$res = $this -> saveToSub ($paper_question->paper_id, $userid, $answertype, $answered, $question);
		}

		if ($res) {
			return $this->succ($request);
		} else {
			throw new \Exception('上传错误');
		}

	}

	/**
	 * 主观题保存到相应表
	 */
	protected function saveToSub ($paper_id, $userid, $answertype, $answered, $question) {
		$question_sub = QuestionsSub::where('pid', $paper_id)
									->where('questionid', $question->questionid)
									->first();
		$question_sub = $question_sub ? $question_sub :	QuestionsSub::create();

		$question_sub->pid = $paper_id;
		$question_sub->userid = $userid;
		$question_sub->subname = $question->question;
		$question_sub->questionid = $question->questionid;
		$question_sub->subtype = $question->questiontype;
		$question_sub->answer_type = $answertype;
		$question_sub->answer_text = $answered;
		$question_sub->answer_img = $answered;
		$question_sub->usertime = time();

		return $question_sub->save();

	}

	/**
	 * 交卷, 获取报告
	 */
	public function assignment (Request $request, Valid $valid) {
		$valid->rule($request, [
			'paper_id' => 'require|integer@试卷id'
		]);
		
		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;
		$paper_id = $request->input('paper_id');
		
		$paper = Paper::where('userid', $userid)->where('id', $paper_id)->first();
		if ($paper) {
			$status = $paper->status;
			if($status == 0) {
				$paper->status = 1;

				$paper_correct = $this->_getPaperCorrect($paper_id, $userid);

				$paper->scored = $paper_correct['scored'];
				$paper->correct_num = $paper_correct['correct_num'];

				$paper->did_num = $this->_countDidNum($paper_id);
				$paper->save();

				return $this->succ($request);

			} else {
				throw new \Exception('不要重复交卷');
			}

		} else {
			throw new \Exception('试卷不存在');
		}
		
	}

	/**
	 * 试题报告统计
	 */
	public function getReport (Request $request, Valid $valid, CouponResponsity $coupon_r) {
		$valid->rule($request, [
			'paper_id' => 'require|integer@试卷'
		]);
		$paper_id = $request->input('paper_id');
		$paper = Paper::find($paper_id);

		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;

		if ($paper) {
			$status = $paper->status;
			if ($status<1) {
				throw new \Exception('该试卷没有提交');
			} else {
				
				$data = [];
				
				$paper = Paper::find($paper_id);
				
				$scored = $paper->scored;
				$data['scored'] = $scored;
				//已做题量(总)
				$did_num_total_obj = Paper::select(DB::raw('sum(did_num) as did_num_total'))
										  ->where('userid', $userid)
										  ->first();
				$did_num_total = $did_num_total_obj->did_num_total;
				$data['did_num_total'] = $did_num_total;
				
				//代金卷
				$couponvalue = $coupon_r->countCoupon($scored);
				$data['couponvalue'] = $couponvalue;
				
				//已做天数
				$did_days_obj = Paper::select(DB::raw('count(id) as did_days'))
									 ->where('userid', $userid)
									 ->where('status', '>', 0)
									 ->groupBy(DB::raw('date_format(created_at, "%Y-%m-%d")'))
									 ->first();
				$did_days = $did_days_obj->did_days;
				$data['did_days'] = $did_days;
				
				//打败考生(天数)
				
				//错题数(总)
				$err_num_obj = DB::table('x2_paper')
							 ->select(DB::raw('sum(did_num - correct_num) as err_num'))
							 ->where('userid', $userid)
							 ->where('status', '>', 0)
							 ->first();
				$err_num = $err_num_obj->err_num;
				$data['err_num'] = $err_num;
				
				
				//本试卷正确率
				$correct_num = $paper->correct_num;
				$did_num = $paper->did_num;
				$correct_rate = $did_num ? floor(($correct_num / $did_num) * 100) . '%' : '0%';
				$data['correct_rate'] = $correct_rate;
				
				//错题打败考生, 为需求, 简单点实现
				//1. 试卷总量
				$exam_num = Paper::all();
				//2. 错题数多余本试卷的试卷数量
				$exam_num_more_err = DB::table('x2_paper')
									   ->where('correct_num', '<', $correct_num)
									   ->get();
				
				$err_win_rate = floor(count($exam_num_more_err)/count($exam_num) * 100) . '%' ;
				$data['err_win_rate'] = $err_win_rate;
									   				
				
				//答题时长
				$created_at = $paper->created_at;
				$updated_at = $paper->updated_at;
				
				$times = strtotime($updated_at) - strtotime($created_at);
				$hours = floor($times / (60 * 60));
				$minutes = floor(($times - $hours * 60 * 60) / 60);
				$seconds = $times - $hours * 60 * 60 - $minutes * 60;
				
				$data['hours'] = $hours;
				$data['minutes'] = $minutes;
				$data['seconds'] = $seconds;
				 
				return $this->succ($request, $data);
				
			}
		} else {
			throw new \Exception('试题不存在');
		}
	}

	/**
	 * 错题概况
	 */
	public function errState(Request $request, Valid $valid) {
		$valid->rule($request, [
			'paper_id' => 'require|integer@试题'
		]);
		$paper_id = $request->input('paper_id');
		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;

		$paper = Paper::where('id', $paper_id)
						->where('userid', $userid)
						->first();

		if ($paper) {

			$status = $paper->status;
			if ($status == 0) {
				throw new \Exception('该试卷没有提交');
			}

			$paper_correct = $this->_getPaperCorrect($paper_id, $userid);
			$data['correct_num'] = $paper_correct['correct_num'];
			$data['scored'] = $paper_correct['scored'];

			$data['paper_id'] = $paper_id;
			$data['did_num'] = $this->_countDidNum($paper_id);
			$data['err_list'] = $this->_getErrList($paper_id);

			return $this->succ($request, $data);

		} else {
			throw new \Exception('试题不存在');
		}
	}
	
	/**
	 * 试卷分析
	 */
	public function parsePaper (Request $request, Valid $valid) {
		$valid->rule($request, [
			'paper_id' => 'require|integer@试卷',
			'question_no' => 'require|integer@试题编号'
		]);
		$paper_id = $request->input('paper_id');
		$question_no = $request->input('question_no');

		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;

		$question = DB::table('x2_paper_questions as A')
						->join('x2_questions as B', 'A.questionid', '=', 'B.questionid')
						->join('x2_paper as C', 'A.paper_id', '=', 'C.id')
						->select('A.question_no', 'A.answered', 'B.question', 'B.questionselect')
						->addSelect('B.questionanswer', 'B.questiondescribe')
						->where('C.status', '>', 0)
						->where('C.userid', $userid)
						->where('A.paper_id', $paper_id)
						->where('A.question_no', $question_no)
						->first();

		$question->question = htmlspecialchars_decode($question['question']);
		$question->questionselect = htmlspecialchars_decode($question['questionselect']);
		$question->questiondescribe = htmlspecialchars_decode($question['questiondescribe']);

		if ($question) {
			return $this->succ($request, $question);
		} else {
			throw new \Exception('试题不存在');
		}
	}

	/**
	 * 试卷分析
	 *
	 * @param int keytype 获取类型, 1: 全部分析, 2: 错题分析
	 */
	public function parsePaperList (Request $request, Valid $valid) {
		$valid->rule($request, [
			'paper_id' => 'require|integer@试卷',
			'keytype' => 'require|integer@获取类型'
		]);

		$paper_id = $request->input('paper_id');
		$keytype = $request->input('keytype');

		$user = JWTAuth::parseToken()->authenticate();
		$userid = $user->userid;

		$list = DB::table('x2_paper_questions as A')
			->join('x2_questions as B', 'A.questionid', '=', 'B.questionid')
			->join('x2_paper as C', 'A.paper_id', '=', 'C.id')
			->select('A.question_no', 'A.answered', 'B.question', 'B.questionselect')
			->addSelect('B.questionanswer', 'B.questiondescribe')
			->where([
				['C.status', '>', 0],
				['C.userid', $userid],
				['A.paper_id', $paper_id],
				['B.questiontype', '<=', 3]
			])
			->where(function ($query) use ($keytype) {
				if($keytype == '2') {
					$query->whereColumn('A.answered', '<>', 'B.questionanswer');
				}
			})
			->orderBy('A.question_no')
			->get();

		foreach ($list as $key => $question) {
			$list[$key]->question = htmlspecialchars_decode($question->question);
			$list[$key]->questionselect = htmlspecialchars_decode($question->questionselect);
			$list[$key]->questionanswer = htmlspecialchars_decode($question->questionanswer);
			$list[$key]->questiondescribe = htmlspecialchars_decode($question->questiondescribe);
		}

		return $this->succ($request, $list);

	}


	/**
	 * 获取模拟试题
	 */
	public function simulate (Request $request, Valid $valid) {
		$valid->rule($request, [
			'paper_id' => 'require'
		]);

		$paper_id = $request->input('paper_id');

		$paper = Paper::find($paper_id);

		if(!$paper) {
			throw new \Exception('试卷不存在');
		}

		$radio_list = $this->_getQuestionsAboutPaper($paper_id, 1);
		$multiple_list = $this->_getQuestionsAboutPaper($paper_id, 2);
		$judgement_list = $this->_getQuestionsAboutPaper($paper_id, 3);
		$subject_list = $this->_getQuestionsAboutPaper($paper_id, 0);

		$data['paper_id'] = $paper_id;

		$data['radio']['total_num'] = count($radio_list);
		$data['radio']['total_score'] = $this->_getTotalScoreAboutPaper($paper_id, 1);
		$data['radio']['list'] = $radio_list;

		$data['multiple']['total_num'] = count($radio_list);
		$data['multiple']['total_score'] = $this->_getTotalScoreAboutPaper($paper_id, 2);
		$data['multiple']['list'] = $multiple_list;

		$data['judgement']['total_num'] = count($radio_list);
		$data['judgement']['total_score'] = $this->_getTotalScoreAboutPaper($paper_id, 3);
		$data['judgement']['list'] = $judgement_list;

		$data['subject']['total_num'] = count($radio_list);
		$data['subject']['total_score'] = $this->_getTotalScoreAboutPaper($paper_id, 0);
		$data['subject']['list'] = $subject_list;

		return $this->succ($request, $data);

	}

	/**
	 * 获取试卷的试题
	 *
	 * @params int paper_id 试卷主键id
	 * @params int  questiontype试题类型, 0:主观题, 1:单选, 2: 多选, 3: 判断
	 *
	 */
	private function _getQuestionsAboutPaper ($paper_id, $questiontype) {

//		$questions = PaperQuestions::select('id', 'answered')
//									->where('paper_id', $paper_id)
//									->with(['question' => function ($query) use ($questiontype) {
//										if ($questiontype > 0) {
//											return $query->addSelect('question', 'questiontype', 'questionselect')
//														->addSelect('questionselectnumber', 'questiondescribe')
//														->where('questiontype', $questiontype);
//										} else {
//											return $query->where('questiontype', '>', 3);
//										}
//									}])
//									->get();
		$questions = DB::table('x2_paper_questions as A')
						->join('x2_questions as B', 'A.questionid', '=', 'B.questionid')
						->select('A.id', 'A.answered', 'B.question', 'B.questiontype', 'B.questionselect')
						->addSelect('B.questionselectnumber', 'B.questiondescribe')
						->where(function ($query) use ($questiontype) {
							if ($questiontype > 0) {
								return $query->where('B.questiontype', $questiontype);
							} else {
								return $query->where('B.questiontype', '>', 3);
							}
						})
						->where('A.paper_id', $paper_id)
						->get();
		foreach($questions as $key=>$v) {
			$questions[$key]->question = htmlspecialchars_decode($v->question);
			$questions[$key]->questionselect = htmlspecialchars_decode($v->questionselect);
		}

		return $questions;

	}

	/**
	 * 获取试卷对应题型的总分
	 */
	private function _getTotalScoreAboutPaper ($paper_id, $questiontype) {
		$paper_question = DB::table('x2_paper_questions as A')
							->select(DB::raw('if(sum(A.score),sum(A.score),0) as score'))
							->join('x2_questions as B', 'A.questionid', '=', 'B.questionid')
							->where('A.paper_id', $paper_id)
							->where(function ($query) use ($questiontype) {
								if($questiontype > 0) {
									return $query->where('B.questiontype', $questiontype);
								} else {
									return $query->where('B.questiontype', '>', 3);
								}
							})
							->first();
		return $paper_question->score;
	}

	//*****************fuck the changed logic******************************end
	
	/**
	 * 获取得分和做对题数
	 */
	private function _getPaperCorrect ($paper_id, $userid) {
		$paper_question = DB::table('x2_paper_questions as A')
			->join('x2_paper as B', 'A.paper_id', '=', 'B.id')
			->join('x2_questions as C', 'A.questionid', '=', 'C.questionid')
			->select(DB::raw('count(A.id) as correct_num'), DB::raw('if(sum(A.score), sum(A.score), 0) as scored'))
			->whereColumn('A.answered', 'C.questionanswer')
			->where('C.questiontype', '<', 4)
			->where('A.paper_id', $paper_id)
			->where('B.userid', $userid)
			->where('A.is_answered', 1)
			->first();
		$correct_num = $paper_question->correct_num;
		$scored = $paper_question->scored;

		$res['correct_num'] = $correct_num;
		$res['scored'] = $scored;

		return $res;

	}
	/**
	 * 获取试题的练习的题数
	 */
	private function _countDidNum ($paper_id) {
		$did_num_obj = DB::table('x2_paper_questions')
			->select(DB::raw('count(id) as did_num'))
			->where('is_answered', 1)
			->where('paper_id', $paper_id)
			->first();
		return $did_num_obj->did_num;
	}

	/**
	 * 错题列表
	 */
	protected function _getErrList ($paper_id) {
		//错题列表
		$err_list = DB::table('x2_paper_questions as A')
			->join('x2_questions as B', 'A.questionid', '=', 'B.questionid')
			->select('A.question_no')
			->where('A.paper_id', $paper_id)
			->where('B.questiontype', '<' , 4)
			->whereColumn('A.answered', '<>', 'B.questionanswer')
			->where('A.is_answered', 1)
			->get();
		return $err_list;
	}

	/**
	 * 获取指定类型试题
	 * @param int questiontype 试题类型
	 * @param	int num 要获取试题的数量
	 */
	protected function _getQuestions ($questiontype, $num, $areaid = 1) {
		$questions = Questions::select('questionid', 'questiontype', 'question', 'questionselect')
								->addSelect('questionselectnumber', 'questiondescribe')
								->where('questiontype', $questiontype)
								->when($areaid>1, function($query) use ($areaid) {
									return $query->where('questionsarea', $areaid);
								})
								->orderBy(DB::raw('rand()'))
								->take($num)
								->get();
		return $questions->toArray();
	}

	/**
	 * 保存试题到 试卷-试题表
	 */
	protected function _saveQuestions ($paper_id, $questions,$start_no = 1, $score = 0 ) {
		$new_questions = [];
		foreach($questions as $key => $question) {
			$new_questions[$key]['paper_id'] = $paper_id;
			$new_questions[$key]['questionid'] = $question['questionid'];
			$new_questions[$key]['score'] = $score ? $score : 3 + floor($key/20);//普通客观题练习是30道题,
			$new_questions[$key]['question_no'] = $start_no + $key;
		}
		DB::table('x2_paper_questions')->insert($new_questions);
	}

	/**
	 * 根据地区名, 获取地区id
	 */
	protected function getAreaid ($areaname) {
		if($areaname) {
			$area = DB::table('x2_area')->select('areaid')->where('area', $areaname)->first();
			if($area) {
				return $area->areaid;
			} else {
				throw new \Exception('所选地区不存在');
			}

		} else {
			return 0;
		}
	}

}
