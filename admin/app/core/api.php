<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
		$this->tpl = $this->G->make('tpl');
		$this->sms = $this->G->make('sms');
		$this->ev = $this->G->make('ev');
		$this->alipayapi = $this->G->make('alipayapi');
		
	}
    public function ceshi()
	{
	 $phone = $this->ev->get('phone');
     $getip = $this->ev->get('getip');
	 $verify = $this->ev->get('verify');
     if ($phone != '' && $getip != '' && $verify != '') {
     	$args =  $this->sms->getSmsjudge($phone, $getip, $verify);
     }else{
    	 $args =array('error'=>2,"sub"=>"必备参数没有填写 请确认填写");
     }
     exit(json_encode($args,JSON_UNESCAPED_UNICODE));
	}
	public function randcode()
	{
		// header("Content-type: image/png");
		$rand = $this->session->setRandCode($rand);
		echo $this->files->createRandImage($rand,67,30);
	}

	public function setsessionid()
	{
		header("Content-type:application/x-javascript");
		$sessionid = $this->session->getSessionId();
		$this->tpl->assign("sessionid",$sessionid);
		$this->tpl->display('setsession');
	}

/*form 提交地址*/
	
	public function finger()
	{
		exit;
		header("Content-type:application/x-javascript");
		$sessionid = $this->session->getSessionId();
		$finger = md5($this->ev->get('finger'));
		if($finger != $sessionid)
		{
			$this->ev->setCookie('psid',$finger,3600*24);
			if(!$this->ev->get('unreload'))
			echo 'window.location.reload();';
		}
		else
		{
			echo 'console.log("ok")';
		}
	}
	/*支付接口*/

	public function zhifu()
	{
		
		$ordersn = $this->ev->get('ordersn');
		$ordertitle = $this->ev->get('ordertitle');
		$orderprice = $this->ev->get('orderprice');
		$ordercenter = $this->ev->get('ordercenter');
		$this->alipayapi->orders($ordersn,$ordertitle,$orderprice,$ordercenter);
	}
	public function notify_url()
	{
		$this->alipayapi->notify_url();
	}
	public function return_url()
	{
		$this->alipayapi->return_url();
	}
}

?>