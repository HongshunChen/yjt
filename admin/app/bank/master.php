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
		$this->files = $this->G->make('files');
		$this->journal = $this->G->make('journal');
		$this->apps = $this->G->make('apps','core');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if($group['groupid'] != 1)
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?core-master-login"
			)));
			else
			header("location:index.php?core-master-login");
		}
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('action',$this->ev->url(2)?$this->ev->url(2):'user');
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->coupon = $this->G->make('coupon','bank'); 
		$this->tpl->assign('apps',$apps);
		$this->orders = $this->G->make('orders','bank');
		$orderstatus = array(1=>'待付款',2=>'已完成',99=>'已撤单');
		$this->tpl->assign('orderstatus',$orderstatus);
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
	}

	public function index()
	{

		
    	header('location:index.php?bank-master-orders-videoorders');
    	exit();
		$this->tpl->assign('orders',$orders);
		$this->tpl->display('index');
		
	}

	public function coupon()
	{
		$action = $this->ev->url(3);
		
		switch ($action) {
			/*自动生成优惠券接口*/
				case 'addcoupon':
				//前台传递过来的优惠券面值
			   $couponvalue = $this->ev->get('couponvalue');	
			  
				
				 $number = $this->coupon->seletNumber($couponvalue);
			
			   if ($number ==false or $number['number']<THRESHOLD) {
			  	 for ($i=0; $i < NUBER_COUPON; $i++) { 
			   		$this->coupon->randCoupon($couponvalue);
			  	 }
			  	  $event = array(
						'event'=>"优惠券自动增加操作",
						'content'=>'系统自动增加'.NUBER_COUPON.'条面值为'.$couponvalue.'元的优惠券数据！',
						);
					$this->journal->addJournal($event);
			   }

			   $mes = array('jx'=>$number);
				exit(json_encode($mes));
					break;
                         case 'outcoupon':
			if($this->ev->get('outcoupon'))
			{
				$stime = strtotime($this->ev->get('stime'));
				$etime = strtotime($this->ev->get('etime'));
				if($stime < $etime)
				{
					$fname = 'data/coupon/'.$stime.'-'.$etime.'-coupon.csv';
					$r = $this->coupon->getAllOKCoupon($stime,$etime);
					if($this->files->outCsv($fname,$r))
					$message = array(
						'statusCode' => 200,
						"message" => "优惠券导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$fname}\">点此下载</a>",
					    "callbackType" => 'forward',
					    "forwardUrl" => "{$fname}"
					);
					else
					$message = array(
						'statusCode' => 300,
						"message" => "优惠券导出失败"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "请选择正确的起止时间"
				);
				exit(json_encode($message));
			}
			else
			{
				$this->tpl->display('outcoupon');
			}
			break;
                        case 'batadd':
			if($this->ev->get('addcoupon'))
			{
				$number = $this->ev->get('createnumber');
				$value = $this->ev->get('couponvalue');
                                $rule = $this->ev->get('couponrule');
                              
				if($number > 0)
				{
//					if($number > 99 )$number = 99;
					if($value < 10)$value = 10;
					if($value > 9999)$value = 9999;
					for($i = 0;$i<$number;$i++)
					{
						$this->coupon->randCoupon($value,$rule);
					}
					$message = array(
						'statusCode' => 200,
						"message" => "优惠券生成成功",
					    "callbackType" => 'forward',
					    "forwardUrl" => "index.php?bank-master-coupon"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "代金券生成失败"
				);
				exit(json_encode($message));
			}
			else
			{
				$this->tpl->display('addcoupon');
			}
			break;
                
				default:
			
		$page = $this->ev->get('page');
		$page = $page > 0?$page:1;	
		$search = $this->ev->get('search');

		$u = '';
		if($search)
		{
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}

		}

		$args = array();
			if($search['couponsn'])$args[] = array('AND',"couponsn = :couponsn",'couponsn',$search['couponsn']);
			if($search['couponvalue'])$args[] = array('AND',"couponvalue = :couponvalue",'couponvalue',$search['couponvalue']);
			if($search['stime'] || $search['etime'])
			{
				if(!is_array($args))$args = array();
				if($search['stime']){
					$stime = strtotime($search['stime']);
					$args[] = array('AND',"couponaddtime >= :couponaddtime",'couponaddtime',$stime);
				}
				if($search['etime']){
					$etime = strtotime($search['etime']);
					$args[] = array('AND',"couponendtime <= :couponendtime",'couponendtime',$etime);
				}
			}
		
		$pages = $this->coupon->getCouponList($args,$page,10);

		
		$this->tpl->assign('pages',$pages);
		$this->tpl->display('coupon');
                }
	}

	public function orders()
	{
		$action = $this->ev->url(3);
		$search = $this->ev->get('search');
		$page = intval($this->ev->get('page'));
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$this->tpl->assign('page',$page);
		switch($action)
		{
			case 'remove':
			$oid = $this->ev->get('ordersn');
			$order = $this->orders->getOrderById($oid);
			if($order['orderstatus'] == 1 || $order['orderstatus'] == 99)
			{
				$this->orders->delOrder($oid);
				$message = array(
					'statusCode' => 200,
					"message" => "订单删除成功",
				    "callbackType" => 'forward',
				    "forwardUrl" => "reload"
				);
			}
			else
			$message = array(
				'statusCode' => 300,
				"message" => "订单操作失败"
			);
			exit(json_encode($message));
			break;

			case 'batremove':
			$delids = $this->ev->get('delids');
			foreach($delids as $oid => $p)
			{
				echo
				$order = $this->orders->getOrderById($oid);
				if($order['orderstatus'] == 1 || $order['orderstatus'] == 99)
				{
					$this->orders->delOrder($oid);
				}
			}
			$message = array(
				'statusCode' => 200,
				"message" => "订单删除成功",
			    "callbackType" => 'forward',
			    "forwardUrl" => "reload"
			);
			exit(json_encode($message));
			break;

			case 'change':
			$ordersn = $this->ev->get('ordersn');
			$orderstatus = $this->ev->get('orderstatus');
			$args = array('orderstatus' => $orderstatus);
			$this->orders->modifyOrderById($ordersn,$args);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?bank-master-orders&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'videoorders':
				$page = $this->ev->get('page');
				$page = $page > 0?$page:1;	

				$search = $this->ev->get('search');

				$u = '';
				if($search)
				{
					foreach($search as $key => $arg)
					{
						$u .= "&search[{$key}]={$arg}";
					}

				}

				$args = array();
					if($search['ordersn']) $args[] = array('AND',"orders.ordersn = :ordersn",'ordersn',$search['ordersn']);
                                        if($search['phoneNum']) $args[] = array('AND',"user.username= :username",'username',$search['phoneNum']);
					if($search['stime'] || $search['etime'])
					{
						if(!is_array($args))$args = array();
						if($search['stime']){
							$stime = strtotime($search['stime']);
							$args[] = array('AND',"orders.ordercreatetime >= :stime",'stime',$stime);
						}
						if($search['etime']){
							$etime = strtotime($search['etime']);
							$args[] = array('AND',"orders.ordercreatetime <= :etime",'etime',$etime);
						}
					}
					if($search['sprice'] || $search['eprice'])
					{
						if(!is_array($args))$args = array();
						if($search['sprice']){
							
							$args[] = array('AND',"orders.orderprice >= :sprice",'sprice',$search['sprice']);
						}
						if($search['eprice']){
							
							$args[] = array('AND',"orders.orderprice <= :eprice",'eprice',$search['eprice']);
						}
					}
				
				$args[] =array("AND","orders.ordertype=:ordertype","ordertype",1);
				$args[]=array("AND","orders.orderuserid = user.userid");
			
				$orders =  $this->orders->getOrderList($args,$page,20);
				//var_dump($orders);die();
				$this->tpl->assign('orders',$orders);
				$this->tpl->display('orders_video');
				break;
			case 'subjectorders':
				$page = $this->ev->get('page');
				$page = $page > 0?$page:1;	

				$search = $this->ev->get('search');

				$u = '';
				if($search)
				{
					foreach($search as $key => $arg)
					{
						$u .= "&search[{$key}]={$arg}";
					}

				}

				$args = array();
					if($search['ordersn'])$args[] = array('AND',"orders.ordersn = :ordersn",'ordersn',$search['ordersn']);
                                        if($search['phoneNum']) $args[] = array('AND',"user.username= :username",'username',$search['phoneNum']);
					if($search['stime'] || $search['etime'])
					{
						if(!is_array($args))$args = array();
						if($search['stime']){
							$stime = strtotime($search['stime']);
							$args[] = array('AND',"orders.ordercreatetime >= :stime",'stime',$stime);
						}
						if($search['etime']){
							$etime = strtotime($search['etime']);
							$args[] = array('AND',"orders.ordercreatetime <= :etime",'etime',$etime);
						}
					}
					if($search['sprice'] || $search['eprice'])
					{
						if(!is_array($args))$args = array();
						if($search['sprice']){
							
							$args[] = array('AND',"orders.orderprice >= :sprice",'sprice',$search['sprice']);
						}
						if($search['eprice']){
							
							$args[] = array('AND',"orders.orderprice <= :eprice",'eprice',$search['eprice']);
						}
					}
				
				$args[] =array("AND","orders.ordertype=:ordertype","ordertype",3);
				$args[]=array("AND","orders.orderuserid = user.userid");
			
				$orders =  $this->orders->getOrderList($args,$page,20);
				$this->tpl->assign('orders',$orders);

				$this->tpl->display('orders_subjectorder');
				break;
			case 'seedingorders':
				$page = $this->ev->get('page');
				$page = $page > 0?$page:1;	
				
				$search = $this->ev->get('search');

				$u = '';
				if($search)
				{
					foreach($search as $key => $arg)
					{
						$u .= "&search[{$key}]={$arg}";
					}

				}

				$args = array();
					if($search['ordersn'])$args[] = array('AND',"orders.ordersn = :ordersn",'ordersn',$search['ordersn']);
                                        if($search['phoneNum']) $args[] = array('AND',"user.username= :username",'username',$search['phoneNum']);
					if($search['stime'] || $search['etime'])
					{
						if(!is_array($args))$args = array();
						if($search['stime']){
							$stime = strtotime($search['stime']);
							$args[] = array('AND',"orders.ordercreatetime >= :stime",'stime',$stime);
						}
						if($search['etime']){
							$etime = strtotime($search['etime']);
							$args[] = array('AND',"orders.ordercreatetime <= :etime",'etime',$etime);
						}
					}
					if($search['sprice'] || $search['eprice'])
					{
						if(!is_array($args))$args = array();
						if($search['sprice']){
							
							$args[] = array('AND',"orders.orderprice >= :sprice",'sprice',$search['sprice']);
						}
						if($search['eprice']){
							
							$args[] = array('AND',"orders.orderprice <= :eprice",'eprice',$search['eprice']);
						}
					}
				
				$args[] =array("AND","orders.ordertype=:ordertype","ordertype",2);
				$args[]=array("AND","orders.orderuserid = user.userid");
			
				$orders =  $this->orders->getOrderList($args,$page,20);

				$this->tpl->assign('orders',$orders);
				$this->tpl->display('orders_seedingorders');
				break;
			case 'ordermodal':
				$orderid = $this->ev->get('id');
				$orders = $this->orders->getOrderById($orderid);

				$this->tpl->assign('orders',$orders);
				$this->tpl->display('orders_videomodal');
				break;
			default:
			if($search)
			{
				$args = array();
			}
			else
			$args = 1;
			$orders = $this->orders->getOrderList($args,$page);
			$this->tpl->assign('orders',$orders);
			$this->tpl->display('orders');
		}
	}
}

?>