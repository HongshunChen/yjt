<?php

class app
{
	public $G;
	public $_user;
	
	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->alipay = $this->G->make('alipay');
		$this->journal = $this->G->make('journal');
		$this->apps = $this->G->make('apps','core');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if($group['groupid'] != 1 && $this->ev->url(2) != 'login')
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
				header("location:index.php?core-master-login");
				exit;
			}
		}
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('action',$this->ev->url(2)?$this->ev->url(2):'user');
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
	}
	public function demo()
	{
		$this->tpl->display('demo');
	}
	public function login()
	{
		
		if($this->ev->get('userlogin'))
		{
			$args = $this->ev->get('args');
			$randcode = strtoupper($this->ev->get('randcode'));
			$_user = $this->session->getSessionValue();
			if(1==1)
			{
				$this->session->setRandCode(0);
				$user = $this->user->getUserByUserName($args['username']);
				if($user['userid'])
				{
					if($user['userpassword'] == md5($args['userpassword']))
					{
						$group = $this->user->getGroupById($user['groupid']);
						if($group['groupmoduleid'] != 1)
						{
							exit(json_encode(array(
								'statusCode' => 300,
								"message" => "您无权进入后台",
							    "callbackType" => 'forward',
							    "forwardUrl" => "index.php?core-master-login"
							)));
						}
						else
						{
							$this->session->setSessionUser(array('sessionuserid'=>$user['userid'],'sessionpassword'=>$user['userpassword'],'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$user['usergroupid'],'sessionlogintime'=>TIME,'sessionusername'=>$user['username']));
							$event = array(
								'event'=>'登录操作',
								'content'=>'登录成功！',
								'userid'=>$user['userid'],
								);	
							$this->journal->addJournal($event,false);
							$message = array(
								'statusCode' => 200,
								"message" => "操作成功，正在转入目标页面",
							    "callbackType" => 'forward',
							    "forwardUrl" => "index.php?core-master"
							);
							exit(json_encode($message));
						}
					}
					else
					{
						$message = array(
							"statusCode" => 300,
							"message" => "操作失败，您的用户名或者密码错误！"
						);
						exit(json_encode($message));
					}
				}
			}
			$message = array(
				"statusCode" => 300,
				"message" => "操作失败，验证码错误！".$_user['sessionrandcode']
			);
			exit(json_encode($message));
		}
		else
		{
			$this->tpl->display('login');
		}
	}

	public function logout()
	{
		$this->session->clearSessionUser();
		$event = array(
					'event'=>'退出登录操作',
					'content'=>'退出成功！',
				);	
		$this->journal->addJournal($event);
		header("location:index.php?core-master-login");
	}

	public function addorders()
	{
		require_once("demo/alipay.config.php");
        require_once("demo/lib/alipay_submit.class.php");

/**************************请求参数**************************/
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $_POST['WIDout_trade_no'];

        //订单名称，必填
        $subject = $_POST['WIDsubject'];

        //付款金额，必填
        $total_fee = $_POST['WIDtotal_fee'];

        //商品描述，可空
        $body = $_POST['WIDbody'];





/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service"       => $alipay_config['service'],
		"partner"       => $alipay_config['partner'],
		"seller_id"  => $alipay_config['seller_id'],
		"payment_type"	=> $alipay_config['payment_type'],
		"notify_url"	=> $alipay_config['notify_url'],
		"return_url"	=> $alipay_config['return_url'],
		
		"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
		"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
        //如"参数名"=>"参数值"
		
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	public function index()
	{
	
		$page = $this->ev->get('page');
		$page = $page>0? $page : 1;
		$pages = $this->apps->getJournalList($page);
		$os = explode(" ", php_uname());
		$fuwu =array(
			'SERVER_NAME'=>$_SERVER['SERVER_NAME'],
			'IP'=>@gethostbyname($_SERVER['SERVER_NAME']),
			'TIME'=>date("Y年n月j日 H:i:s"),
			'XITONG'=>$os[0],
			'BANBEN'=>$os[2],
			'YINQING'=>$_SERVER['SERVER_SOFTWARE'],
			'DUANKOU'=>$_SERVER['SERVER_PORT'],
			'PHPBANBEN'=>PHP_VERSION,

			);
		
		$this->tpl->assign('fuwu',$fuwu);
		$this->tpl->assign('pages',$pages);
		$this->tpl->display('index');
	}

/*支付接口*/
	public function playapi()
	{
		$action = $this->ev->url(3);
		switch ($action) {
			case 'addplayapi':
				$args['partner'] = $this->ev->get('partner');
				$args['seller_id'] = $this->ev->get('seller_id');
				$args['key'] = $this->ev->get('key');
				$args['notify_url'] = $this->ev->get('notify_url');
				$args['return_url'] = $this->ev->get('return_url');
				$cfid = $this->ev->get('cfid');
				$data = array('playapi',$args,array(array('and','cfid =:cfid','cfid',$cfid)));
				$sql = $this->pdosql->makeUpdate($data);

				$mes = $this->db->exec($sql);

				exit(json_encode($mes));

				break;
			
			default:
			$config = $this->apps->getPlayAPI(1);
			$this->tpl->assign('config',$config);	
			$this->tpl->display('playapi');
				break;
		}
	
	}

/*短息配置*/
	public function message()
	{
		$action = $this->ev->url(3);

		switch ($action) {
			case 'addsms':
				
			$args['cfgapp'] =  $this->ev->get('smsname');	
			$args['cfgsetting'] = $this->ev->get('smspwd');
			$cfid = $this->ev->get('cfid');

			$data = array('config',$args,array(array("AND","cfid = :cfid",'cfid',$cfid)));
			$sql = $this->pdosql->makeUpdate($data);

			$mes = $this->db->exec($sql);

			exit(json_encode($mes));
			case 'addtemplate':
				

				$args['smsname'] = $this->ev->get('name');
				$args['smstemplate'] = $this->ev->get('template');
				$args['smsautograph'] = $this->ev->get('autograph');
				$id = $this->ev->get('id');

				$data = array('smsmobile',$args,array(array("AND","id = :id",'id',$id)));
				$sql = $this->pdosql->makeUpdate($data);

				$mes = $this->db->exec($sql);
				exit(json_encode($mes));

				break;
				break;
			
			default:

		$mobile = $this->apps->getSmsmobileList();
		
		$config = $this->apps->getConfigList(1);
		$this->tpl->assign('config',$config);
		$this->tpl->assign('mobile',$mobile);
		$this->tpl->display('message');
				break;
		}

	
	}

/*系统设置*/
	public function setting()
	{
		$time = time()-3600*24*7;
		$number = $this->apps->deleDayList($time);

		$event =array(
			'event'=>'删除日志操作',
			'content'=>'删除了'.$number.'条日志数据',
			);
		$this->journal->addJournal($event);
		$message = array(
			'statusCode' => 200,
			"message" => '操作成功',
			 "callbackType" => 'forward',
			"forwardUrl" => "index.php?core-master"
			);
		$this->G->R($message);
	}
/*模块管理*/
	public function apps()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'config':
			$appid = $this->ev->get('appid');
			if($this->ev->get('appconfig'))
			{
				$args = $this->ev->get('args');
				
				$args['appsetting'] = $args['appsetting'];
				$app = $this->apps->getApp($appid);
				if($app)
				{
					$this->apps->modifyApp($appid,$args);
				}
				else
				{
					$this->apps->addApp($appid,$args);
				}
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功，正在转入目标页面",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?core-master-apps"
				);
				exit(json_encode($message));
			}
			else
			{
				$app = $this->apps->getApp($appid);
				$this->tpl->assign('appid',$appid);
				$this->tpl->assign('app',$app);
				$this->tpl->display('config');
			}
			break;

			default:
			$this->tpl->display('apps');
		}
	}
}

?>