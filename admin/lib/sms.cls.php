<?php 
header("Content-Type: text/html; charset=UTF-8");
/**
* 短信验证类
*/
class sms
{
	public $G;	
	public function __construct(&$G)
    {
    	$this->G = $G;
 	   	$this->ev = $this->G->make('ev');
 	   	$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->apps = $this->G->make('apps','core');
    }

    /**
     * [getSmsaddList 判断数据库中是否已有改用户 然后选择插入方式]
     * @param  [type] $phone [用户请求手机号码]
     * @param  [type] $getip [用户地址IP]
     * @return [type]        [description]
     */
    public function getSmsaddList($phone, $getip, $verify)
    {
    	$args=array(array('AND',"phone=:phone",'phone',$phone));
    	$data = array(false,'verifycode',$args);
		$sql = $this->pdosql->makeSelect($data);
		$params = $this->db->fetch($sql);
		
		if ($params) {

			$args = array(
				'phone'=>$phone,
				'number'=>$params['number']+1,
				'code' =>$verify,
				);
			
		$this->getSmsVerifyCode($phone,$verify);	
		$data = array('verifycode',$args,array(array("AND","phone = :phone",'phone',$phone)));
		$sql = $this->pdosql->makeUpdate($data);
		$this->db->exec($sql);
		}else{


    	$verify = rand(123456, 999999);
    	$args = array(
    		'phone'=>$phone,
    		'getip'=>$getip,
    		'code'=>$verify,
    		'datetime'=>date('Y-m-d H:i:s',time()),
    		'is_sur'=>0,
    		'number'=>1,
    		);
    	 $data = $this->db->insertElement(array('table'=>'verifycode','query'=>$args));
    	 $this->getSmsVerifyCode($phone,$verify);	
    	}
    }
	/*时间判断是否超过时间或者条数*/
    public function getSmsjudge($phone,$getip, $verify)
    {		
    	$args=array(array('AND',"phone=:phone",'phone',$phone));
    	$data = array(false,'verifycode',$args);
		$sql = $this->pdosql->makeSelect($data);
		$params = $this->db->fetch($sql);

		$one = strtotime($params['datetime']);
		$tow = strtotime(date('Y-m-d H:i:s',time()));
		$cle = $tow - $one;

		if (($cle/3600)<=1) {
			if ($params['number']>=5) {
				$meass =array(
					'error'=>1,
					'message'=>"一小时内请求次数不得超过5次"
					);
				return $meass;
			}else{
				$this->getSmsaddList($phone,$getip, $verify);
				$meass =array(
					'error'=>0,
					'message'=>"验证成功"
					);
				return $meass;
			}
		}elseif(($cle/3600)<=24){
			if ($params['number']>=10) {
				$meass =array(
					'error'=>2,
					'message'=>"1天内请求次数不得超过10次"
					);
				return $meass;
			}else{

			$this->getSmsaddList($phone, $getip, $verify);
			$meass =array(
					'error'=>0,
					'message'=>"验证成功!"
					);
			return $meass;
			}
		}else{
			/*超过24小时 刷新时间记录*/
			 $this->deletesms($phone);
		  $this->getSmsaddList($phone, $getip, $verify);
		  $meass = array(
		  	'error'=>0,
		  	'message'=>"新加记录并验证成功"
		 );
		  return $meass;
		}
    }

    public function getSmsVerifyCode($phone,$verify)
    {
	    	$flag = 0; 
			$params='';//要post的数据 
	    	$config = $this->apps->getConfigList(1);
	    	$mobile = $this->apps->getSmsmobileList();
	    	$content = str_replace('@',$verify,$mobile['smstemplate']);

	    	$argv = array( 
			'name'=>$config['cfgapp'],     //必填参数。用户账号
			'pwd'=>$config['cfgsetting'],     //必填参数。（web平台：基本资料中的接口密码）
			'content'=>$content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
			'mobile'=>$phone,   //必填参数。手机号码。多个以英文逗号隔开
			'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
			'sign'=>$mobile['smsautograph'],    //必填参数。用户签名。
			'type'=>'pt',  //必填参数。固定值 pt
			'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
			 );
			 foreach ($argv as $key=>$value) { 
				if ($flag!=0) { 
					$params .= "&"; 
					$flag = 1; 
				} 
				$params.= $key."="; $params.= urlencode($value);// urlencode($value); 
				$flag = 1; 
			} 

			$url = "http://web.wasun.cn/asmx/smsservice.aspx?".$params; //提交的url地址
			$con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
			// var_dump(file_get_contents($url));die();
			if($con == '0'){
				$meass =array(
					'error'=>0,
					'message'=>"验证成功!"
					);
			return $meass;
			}else{
				$meass =array(
					'error'=>4,
					'message'=>"验证失败!"
					);
			} 
    }

    public function deletesms($phone)
    {	
    	$data = array('verifycode',array(array("AND","phone = :phone",'phone',$phone)));
    	$sql = $this->pdosql->makeDelete($data);
		return $this->db->exec($sql);
    }

}
?>