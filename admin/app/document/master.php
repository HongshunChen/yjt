<?php

class app
{
	public $G;

	//初始化信息
	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if($group['groupmoduleid'] != 1)
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?core-master-login"
			)));
			else
			{
				header("location:?core-master-login");
				exit;
			}
		}
		//生产一个对象
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->apps = $this->G->make('apps','core');
		$this->journal =$this->G->make('journal');
		$this->attach = $this->G->make('attach','document');
		$this->question = $this->G->make('question','document');
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
		$userid = $this->user->getUserById($_user['sessionuserid']);
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
	}

	

	public function index()
	{
		header("Location:index.php?document-master-subjective");
		exit();
		$this->tpl->display('index');
	}

	public function subjective()
	{
		$action = $this->ev->url(3);

		switch ($action) {
			case 'subject':

				 $this->tpl->display('subjective_subject');
				break;
			case 'modal':
				 $catid = $this->ev->get('catid');
				 $question = $this->question->getQuestionSubjectById('questions_sub','subid',$catid);
				 $user = $this->question->getQuestionSubjectById('user','userid',$question['userid']);
					if ($user['usertruename']) {
						$question['username'] = $user['usertruename'];
					}else{
						$question['username'] = $user['username'];
					}
				 $questype = $this->question->getQuestionSubjectById('questype','questid',$question['subtype']);
				 $question['questype'] = $questype['questype'];
			
				 $this->tpl->assign('question',$question);
				 $this->tpl->display('subjective_modal');
				break;
			case 'addsubject':
				
				if($this->ev->get('insertquestype')){	
					$args = $this->ev->get('args');
					$args['teachertime'] = time();
					$id = $this->ev->get('courseid');
					$this->question->getSubjectiveList($id,$args);
					$event = array(
						'event'=>'主观题批改记录',
						'content'=>$userid['usertruename'].'批改了主观题',
						);
					$this->journal->addJournal($event);
 					$message = array(
					'statusCode' => 200,
					"message" => "批改成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?document-master-subjective"
					);
					$this->G->R($message);
				};
				 $catid = $this->ev->get('catid');
				 $question = $this->question->getQuestionSubjectById('questions_sub','subid',$catid);
				 $user = $this->question->getQuestionSubjectById('user','userid',$question['userid']);
					if ($user['usertruename']) {
						$question['username'] = $user['usertruename'];
					}else{
						$question['username'] = $user['username'];
					}
				 $questype = $this->question->getQuestionSubjectById('questype','questid',$question['subtype']);
				 $question['questype'] = $questype['questype'];
			
				 $this->tpl->assign('question',$question);

				$this->tpl->assign('courseid',$catid);
				$this->tpl->display("subjective_addsubject");
				break;
			default:
				 $page = $this->ev->get('page');
				 $page = $page > 0?$page:1;

				 $pages = $this->question->getQuestionSubjectList($page,20,0,1);	

				 $this->tpl->assign('pages',$pages);
				 $this->tpl->display('subjective_index');
				break;
		}
	}
	public function selfquestions()
	{
	       $action = $this->ev->url(3);
	       switch ($action) {
	       	case 'addselfquestions':

	       	if($this->ev->get('insertquestype')){	
					$args = $this->ev->get('args');
					$args['teachertime'] = time();
					$id = $this->ev->get('courseid');
					$this->question->getSubjectiveList($id,$args);
					$event = array(
						'event'=>'自备题批改记录',
						'content'=>$userid['usertruename'].'批改了自备题',
						);
					$this->journal->addJournal($event);
 					$message = array(
					'statusCode' => 200,
					"message" => "批改成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?document-master-selfquestions"
					);
					$this->G->R($message);
				};
	       		 $catid = $this->ev->get('catid');
				 $question = $this->question->getQuestionSubjectById('questions_sub','subid',$catid);
				 $user = $this->question->getQuestionSubjectById('user','userid',$question['userid']);
					if ($user['usertruename']) {
						$question['username'] = $user['usertruename'];
					}else{
						$question['username'] = $user['username'];
					}
				$questype = $this->question->getQuestionSubjectById('questype','questid',$question['subtype']);
				$question['questype'] = $questype['questype'];
			
				$this->tpl->assign('question',$question);


				$this->tpl->assign('courseid',$catid);

	       		$this->tpl->display("selfquestions_addselfquestions");
	       		break;
	       	
	       	default:

	       		 $page = $this->ev->get('page');
				 $page = $page > 0?$page:1;

				 $pages = $this->question->getQuestionSubjectList($page,20,0,0);	

				 $this->tpl->assign('pages',$pages);		
	       		 $this->tpl->display('selfquestions_index');
	       		break;
	       }
	}
}

?>