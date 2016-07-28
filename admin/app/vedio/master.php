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
		$this->journal = $this->G->make('journal');
		$this->apps = $this->G->make('apps','core');
		$this->vedio = $this->G->make('vedio','vedio');
		$this->recyle = $this->G->make('recyle','vedio');
		$this->attach = $this->G->make('attach','document');
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
		$this->userid = $this->user->getUserById($_user['sessionuserid']);
		$this->username =$this->user->getUserById($_user['sessionuserid']);

		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
	}


	public function index()
	{	
		header('location:index.php?vedio-master-demand-area');

		
		$this->tpl->display('index');
	}

	/*直播模块*/
	public function seeding()
	{
		
		$action = $this->ev->url(3);
		
		switch ($action) {
			case 'addseeding':
			
			
			if ($this->ev->get('insertquestype')) {
				
					$args = $this->ev->get('args');
					$args['createtime']	 = time();
					$args['endtime'] = strtotime($args['endtime']);
					$args['uid'] = $this->username['userid'];
				
				$data = $this->db->insertElement(array('table'=>'video_special','query'=>$args));
				
				 if ($data){
					$message = array(

					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-seeding"
						);
				}else{
					$message = array(
					'statusCode'=>300,
					'message'=>"操作失败！",
					'callbackType'=>'forward',
					'forwardUrl'=>'index.php?vedio-master-seeding-addseeding'
						);
				}
				$this->G->R($message);
				}				
   
			$courseify = $this->vedio->getVediocat();
			$this->tpl->assign('courseify',$courseify);
			$this->tpl->display('seeding_addseeding');
				break;
			case 'editseeding':
				if ($this->ev->get('insertquestype')) {
					$catid = $this->ev->get('catid');
					$args =  $this->ev->get('args');

					$args['endtime'] =strtotime($args['endtime']);
				
					$data = $this->vedio->getSeedingDelet($catid,$args); 
					if ($data) {
					$message = array(
						'statusCode'=>200,
						'message'=>'操作成功',
						'callbackType'=>'forward',
						'forwardUrl'=>'index.php?vedio-master-seeding'
						);
				}else{

					$message = array(
						'statusCode'=>300,
						'message'=>"操作失败！",
						'callbackType'=>'forward',
						'forwardUrl'=>'index.php?vedio-master-seeding-editseeding'
						);
				}
				$this->G->R($message);
				}

				$catid = $this->ev->get('catid');
				$cat = $this->vedio->getSeedingById($catid);
				$courseify = $this->vedio->getVediocat();
				$this->tpl->assign('courseify',$courseify);
				$this->tpl->assign('cat',$cat);
				$this->tpl->display('seeding_editseeding');
				break;
			case 'deletseeding':
			 $catid = $this->ev->get('catid');	
			 $args['is_delet'] = 1;
			 $this->vedio->getSeedingDelet($catid,$args);
			 $message =array(
			 	'statusCode'=>200,
			 	'message'=>"操作成功!",
			 	'callbackType'=>"forward",
			 	'forwardUrl'=>"index.php?vedio-master-seeding"
			 	);
			 $this->G->R($message);
				break;
			case 'detail':
			$cid = $this->ev->get('videoid');

			$cat = $this->vedio->getSeedingById($cid);

			$this->tpl->assign('cat',$cat);
			$this->tpl->display('seeding_detail');
				break;
			default:

			$page = $this->ev->get('page');
			$page = $page>0? $page : 1;

			$pages = $this->vedio->getSeedingList($args,$page,20,0);
			$this->tpl->assign('pages',$pages);
			$this->tpl->display('seeding_index');
				break;
		}

	
	}

	/*回收站*/
	public function recyle()
	{
     	$action = $this->ev->url(3);
     	
     	switch ($action) {
     		case 'course':
     			$page = $this->ev->get('page');
				$page = $page > 0?$page:1;	
				
				$pages =  $this->vedio->getVediocourseList($page,20,1);


				$this->tpl->assign('pages',$pages);
     			$this->tpl->display('recyle_course');
     			break;
     		case 'regaincourse':
     		 $catid = $this->ev->get('catid');
			 $args= array('is_delet'=>'0');
			
			 $this->vedio->deecourse($catid,$args);
			 $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-recyle-course"
				);
			 $this->G->R($message);
     			break;
     		case 'deecourse':
     			$catid = $this->ev->get('catid');
     			$this->recyle->deecourse($catid);
     		 	$cat = $this->vedio->getCourse($catid);
				 $event= array(
			 	'event'=>'删除课程操作',
			 	'content'=>"成功删除了".$cat['coursename'],
			 	);
			 	$this->journal->addJournal($event);

     			 $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-recyle-course"
				);
			 $this->G->R($message);
     			break;
     		case 'vedio':
     			$page = $this->ev->get('page');
				$page = $page > 0?$page:1;	
				$cat = $this->vedio->getVedioVediolis($page,20,1);
				$this->tpl->assign('pages',$cat);
     			$this->tpl->display('recyle_vedio');
     			break;
     		case 'editvedio':
     			$videoid = $this->ev->get('catid');
				 $args= array('is_delet'=>'0');
			
				 $this->vedio->deevedio($videoid,$args);
				  $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-recyle-vedio"
				);
			 $this->G->R($message);
     			break;
     		case 'deevedio':
     			$catid = $this->ev->get('catid');
     			$this->recyle->deevedio($catid);
     			$cat = $this->vedio->getVediovideo($catid);
     			 $event= array(
			 	'event'=>'删除视频操作',
			 	'content'=>"成功删除了".$cat['videoname'],
			 	);
			 	$this->journal->addJournal($event);
     			 $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-recyle-vedio"
				);
			 $this->G->R($message);
     			break;
     		case 'seeding':
     			$page = $this->ev->get('page');
				$page = $page>0? $page : 1;

				$pages = $this->vedio->getSeedingList($args,$page,20,1);
				$this->tpl->assign('pages',$pages);
     			$this->tpl->display('recyle_seeding');
     			break;
     		case 'regainseeding':
     			$catid = $this->ev->get('catid');
     			$args['is_delet'] =0;
				$this->vedio->getSeedingDelet($catid,$args);
				 $message =array(
				 	'statusCode'=>200,
				 	'message'=>"操作成功!",
				 	'callbackType'=>"forward",
				 	'forwardUrl'=>"index.php?vedio-master-recyle-seeding"
				 	);
				 $this->G->R($message);
     			break;
     		case 'deletseeding':
     			$catid = $this->ev->get('catid');
     			$this->recyle->deeseeding($catid);
     			$cat = $this->vedio->getSeedingById($catid);
     			$event =array(
     				'event'=>'删除直播课程操作',
     				'content'=>"删除了视频模块下的".$cat['vname']."课程",
     				);
     			$this->journal->addJournal($event);
     			$message = array(
     				'statusCode'=>200,
     				'message'=>'删除成功',
     				'callbackType'=>'forward',
     				'forwardUrl'=>'index.php?vedio-master-recyle-seeding'
     				);
     			$this->G->R($message);
     			break;
     		default:
     			# code...
     			break;

     	}
	}


	public function demand()
	{
		$action = $this->ev->url(3);
		switch ($action) {
			case 'vedio':

			
			$courseid =  $this->ev->get('catid');
			$args = array(array('AND',"courceid=:courceid",'courceid',$courseid),
				array("AND","videotype =:videotype",'videotype',0),
				array("AND","is_delet =:is_delet",'is_delet',0),
				);
			$cat = $this->vedio->getCourseVideo($args);

			$this->tpl->assign('courseid',$courseid);
			$this->tpl->assign('pages',$cat);
			$this->tpl->display('demand_vedio');

				break;
			case 'addvedio':
			$courseid = $this->ev->get('catid');
		
				if ($this->ev->get('insertquestype')) {
				  $args = $this->ev->get('args');
				  $courseid = $this->ev->get('courseid');
				  $args['createtime'] = time();
				 
				  if ($this->vedio->getVediolist($args['videovid'])){
					$message=array(
							'statusCode' => 300,
							"message" => "视频重复,请选择上传的视频",
						    "callbackType" => 'forward',
						    "forwardUrl" => "index.php?vedio-master-demand-addvedio&catid=$courseid",
						);	
					exit(json_encode($message));
				  }


				 $data = $this->db->insertElement(array('table'=>'videos','query'=>$args));
				 if ($data){

				 	$message = array(
						 	'statusCode' => 200,
							"message" => "视频添加成功",
						    "callbackType" => 'forward',
						    "forwardUrl" => "index.php?vedio-master-demand-vedio&catid=$courseid",
				 		); 
				 }else{
				 	$message = array(
							'statusCode' => 300,
							"message" => "视频添加失败",
						    "callbackType" => 'forward',
						    "forwardUrl" => "index.php?vedio-master-demand-addvedio&catid=$courseid",

				 		);
				 }
				 $this->G->R($message);

				}else{


		     	$cat = $this->vedio->getkecheng();

		     	$this->tpl->assign('courseid',$courseid);
		     	$this->tpl->assign('cat',$cat);
				$this->tpl->display('demand_addvedio');
				}
				break;
			case 'editvedio':
				
			if ($this->ev->get('insertquestype')) {
				
				$args = $this->ev->get('args');
				$catid =  $this->ev->get('catid');
				 $args['createtime'] = time();
				$courseid = $this->ev->get('courseid');
				
				$this->vedio->editVediovedio($catid,$args);
			
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-demand-vedio&catid=$courseid"
				);
				$this->G->R($message);	
			}else{
				$courseid = $this->ev->get('courseid');

				$videoid = $this->ev->get('catid');

				$cat = $this->vedio->getVediovideo($videoid);
				$kecheng = $this->vedio->getkecheng();
				$this->tpl->assign('courseid',$courseid);
		     	$this->tpl->assign('kecheng',$kecheng);
				$this->tpl->assign('cat',$cat);
				$this->tpl->display('demand_editvedio');
				}
				break;
			case 'deevedio':
				$videoid = $this->ev->get('catid');
				$courseid = $this->ev->get('courseid');
				 $args= array('is_delet'=>'1');
			
				 $this->vedio->deevedio($videoid,$args);
				  $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-demand-vedio&catid=$courseid"
				);
			 $this->G->R($message);
				break;
			case 'detail':
				$videoid = $this->ev->get('videoid');

				$cat = $this->vedio->getVediovideo($videoid);
				$this->tpl->assign('cat',$cat);
				$this->tpl->display('vedio_detail');
				break;
			case 'area':
			$cat = $this->vedio->getVediocat();	
			$params = $this->vedio->getVediocat();
			$this->tpl->assign('params',$params);
			$this->tpl->assign('cat',$cat);
			$this->tpl->display('demand_area');
				break;

			case 'addarea':
			
			if ($this->ev->get('insertquestype')) {
		      	$args = $this->ev->get('args');
		      	$event =array(
						'event'=>'增加课程分类',
						"content"=>'增加了'.$args['catname'],
						);
				$this->journal->addJournal($event);
				$data = $this->db->insertElement(array('table'=>'vedio_cat','query'=>$args));
				if ($data) {
					$message = array(
					'statusCode' => 200,
					"message" => "分类添加成功",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?vedio-master-demand-area"
					);
				exit(json_encode($message));
				}else{

					$message = array(
					'statusCode' => 300,
					"message" => "分类添加失败",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?vedio-master-demand-addarea"
					);
				}
			}	

			$this->tpl->display('demand_addarea');
				
				break;

			case 'addarea_fenlei':

			if ($this->ev->get('insertquestype')) {
		      	$args = $this->ev->get('args');

				$data = $this->db->insertElement(array('table'=>'vedio_cat','query'=>$args));
				if ($data) {

					$message = array(
					'statusCode' => 200,
					"message" => "分类添加成功",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?vedio-master-demand-area"
					);
				exit(json_encode($message));
				}else{

					$message = array(
					'statusCode' => 300,
					"message" => "分类添加失败",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?vedio-master-demand-addarea_fenlei"
					);
				}
			}	

				$catid = $this->ev->get('catid');
			   $params = $this->vedio->setVediocat($catid);


				$this->tpl->assign('params',$params);
				$this->tpl->display('demand_addarea_fenlei');
				break;
			//修改分类
			case 'editarea':
			if ($this->ev->get('insertquestype')) {

				$args = $this->ev->get('args');
				$catid =  $this->ev->get('catid');
				$this->vedio->editVediocat($catid,$args);

				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-demand-area"
				);
				$this->G->R($message);	
			}else{
			$catid = $this->ev->get('catid');
			$cat = $this->vedio->setVediocat($catid);
			$params = $this->vedio->setVediocatpid($cat['catpid']);
			$this->tpl->assign('params',$params);
			$this->tpl->assign('cat',$cat);
			$this->tpl->display('demand_editarea');
			}
				break;
			//删除
			case 'deearea':
		     $catid = $this->ev->get('catid');
		     $cat = $this->vedio->setVediocat($catid);
		     $event =array(
		     	'event'=>'删除分类操作',
		     	'content'=>'删除了'.$cat['catname'],
		     	);
		     $this->journal->addJournal($event);
		     $this->vedio->deeVediocat($catid);
			 $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-demand-area"
				);
			 $this->G->R($message);
				break;
			case 'course':

				$page = $this->ev->get('page');
				$page = $page > 0?$page:1;	
			
				$pages =  $this->vedio->getVediocourseList($page,20,0);

				$this->tpl->assign('pages',$pages);
				$this->tpl->display('demand_course');
				break;
			case 'addcourse':

				if ($this->ev->get('insertquestype')){
					$course = $this->ev->get('args');
					$course['coursetime'] = time();
                                        $args['courseendtime'] = strtotime($args['courseendtime']);
					$data = $this->db->insertElement(array('table'=>'video_course','query'=>$course));
				if ($data) {
					$message= array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?vedio-master-demand-course"
						);
				}else{
					$message= array(
						'statusCode' => 300,
						"message" => "操作失败",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?vedio-master-demand-addcourse"
						);
				}
				$this->G->R($message);
				}else{
				$courseify = $this->vedio->getVediocat();
				
				$this->tpl->assign('courseify',$courseify);
				$this->tpl->display('demand_addcourse');
				}
				break;
			case 'editcourse':
			if ($this->ev->get('insertquestype')) {

				
				$args = $this->ev->get('args');
                                $args['courseendtime'] = strtotime($args['courseendtime']);
				$args['coursetime'] = time();
				$catid =  $this->ev->get('catid');

				$data = $this->vedio->getEditCourse($catid,$args);
				if ($data) {
					$message= array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?vedio-master-demand-course"
						);
				}else{
					$message= array(
						'statusCode' => 300,
						"message" => "操作失败",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?vedio-master-demand-editcourse"
						);
				}
				$this->G->R($message);
				
			}else{		

				$courseify = $this->vedio->getVediocat();

				$this->tpl->assign('courseify',$courseify);
				$catid = $this->ev->get('catid');
				$cat = $this->vedio->getCourse($catid);
				$this->tpl->assign('cat',$cat);
				$this->tpl->display('demand_editcourse');
				break;
			}
			case 'deecourse':
			 $catid = $this->ev->get('catid');
			 $args= array('is_delet'=>'1');
			 $arr = array(array("AND","videotype=:videotype",'videotype',0),
			 	array("AND","is_delet=:is_delet",'is_delet',0),
			 	array('AND',"courceid=:courseid",'courseid',$catid),
			 	);
			
			if ($this->vedio->getCourseVideo1($arr)) {
				$message = array(
					'statusCode' => 300,
					"message" => "请先删除该课程下的视频",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-demand-course"
				);
				
			}else{
			
			 $this->vedio->deecourse($catid,$args);
			
			 $message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?vedio-master-demand-course"
				);
			 }
			 $this->G->R($message);
				break;
			case 'subject':

		 	$pages = $this->vedio->getSubjectList($args,$page,20);	
		  	$this->tpl->assign('pages',$pages);
			$this->tpl->display('demand_subject');
				# code...
				break;
			default:
				# code...
				break;
		}
	}


}
?>