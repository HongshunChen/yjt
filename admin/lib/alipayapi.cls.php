<?php


class alipayapi{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$this->userid = $this->user->getUserById($_user['sessionuserid']);
		$this->db = $this->G->make('pepdo');
		$this->journal = $this->G->make('journal');
		$this->user = $this->G->make('user','user');
	}


	public function orders($out_trade_no,$subject,$total_fee,$body)
	{
		require_once("lib/alipay.config.php");
		require_once("lib/alipay_submit.class.php");

/**************************请求参数**************************/
        // //商户订单号，商户网站订单系统中唯一订单号，必填
        // $out_trade_no = $_POST['WIDout_trade_no'];

        // //订单名称，必填
        // $subject = $_POST['WIDsubject'];

        // //付款金额，必填
        // $total_fee = $_POST['WIDtotal_fee'];

        // //商品描述，可空
        // $body = $_POST['WIDbody'];





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

/*异步回调函数*/
	public function notify_url()
	{
				require_once("lib/alipay.config.php");
				require_once("lib/alipay_notify.class.php");

				//计算得出通知验证结果
				$alipayNotify = new AlipayNotify($alipay_config);
				$verify_result = $alipayNotify->verifyNotify();

				if($verify_result) {//验证成功
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					$price = $_POST['price'];

					//支付宝交易号

					$trade_no = $_POST['out_trade_no'];

					//交易状态
					$trade_status = $_POST['trade_status'];


				    if($_POST['trade_status'] == 'TRADE_FINISHED') {
						
				    } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
						
						$this->journal->Updateorders($trade_no);//交易成功，更改订单状态
				    }

					
					echo "success";		//请不要修改或删除
					
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}
				else {
				    //验证失败
				    echo "fail";

				    //调试用，写文本函数记录程序运行情况是否正常
				    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
				}
	}

	/*前台调用地址*/
	public function return_url()
	{
				require_once("lib/alipay.config.php");
				require_once("lib/alipay_notify.class.php");
				
echo <<<EOT
			<!DOCTYPE HTML>
				<html>
				    <head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
EOT;
				//计算得出通知验证结果
				$alipayNotify = new AlipayNotify($alipay_config);
				$verify_result = $alipayNotify->verifyReturn();
				if($verify_result) {//验证成功
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//请在这里加上商户的业务逻辑程序代码
					
					//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
				    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

					//商户订单号
					$price = $_POST['price'];

					//支付宝交易号

					$trade_no = $_POST['out_trade_no'];

					//交易状态
					$trade_status = $_POST['trade_status'];


				    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
						//判断该笔订单是否在商户网站中已经做过处理
							//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
							//如果有做过处理，不执行商户的业务程序
				    }
				    else {
				      echo "trade_status=".$_GET['trade_status'];
				    }
						
					echo "验证成功<br />";

					//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
					
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}
				else {
				    //验证失败
				    //如要调试，请看alipay_notify.php页面的verifyReturn函数
				    echo "验证失败";
				};
				
				echo "<title>支付宝即时到账交易接口</title></head><body></body></html>";
	 
					}
				
}
?>
