<?php
	namespace App\Plugins\Message;
	
	class Message {
		
		private $debug = false;
		private $times = 60;
		
		/**
		 * 生成验证码
		 */
		private function createCode($request, $mobile){
			
			$timestamp = time();
			$old_timestamp = $request->session()->get("code_timestamp");
			
			if($this->debug){
				$old_timestamp = 0;
			}
			if(!isset($old_timestamp) || ($timestamp - $old_timestamp) > $this->times ){
				//测试环境暂时使用123456
				if($this->debug){
					$msmCode = '123456';
				}else{
					$msmCode = rand(100000,999999);
				}
				
				//保存到session,方便验证
				$request->session()->put("msmCode",$msmCode);
				$request->session()->put("code_timestamp",$timestamp);
				$request->session()->put("code_mobile",$mobile);
				
				return $msmCode;
				
			}else{
				return '';
			}
			
		}
		/**
		 * 获取验证码
		 */
		public function getCode($request){
			
			return $request->session()->get("msmCode");
			
		}
		
		/**
		 * 发送验证码
		 */
		public function sendCode($request, $mobile){
			
			$res = array("status"=>"0","msg"=>"");
				
			$msmCode = $this->createCode($request, $mobile);
			
			if($msmCode){
				//测试环境暂时使用123456
				if(!$this->debug){
					
	   				$sss = substr(microtime(),2,3);
	   				$timestamp = date('YmdHis',time()) . $sss;
					
	   				$content = '您的验证码是：'.$msmCode;

					$params = '&phone=' . $mobile . '&getip=' . $request->getClientIp() . '&verify=' . $msmCode;
					$url = 'http://120.27.47.182/admin/index.php?core-api-ceshi' . $params;
					
					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);

					curl_exec($ch);
					curl_close($ch);
					
				}
				
				$res['status'] = 1;

			}else{
				$res['msg'] = "不要重复发送";
			}
			
			return $res;

		}
		
		/**
		 * 验证码验证
		 * @return 0:验证失败,1:验证成功
		 */
		public function checkCode($request, $inputCode, $mobile){
			
			$msmCode = $request->session()->get("msmCode");
			$codeMobile = $request->session()->get("code_mobile");
			
			if($msmCode == $inputCode && $mobile == $codeMobile){
				$this->destoryCode($request);
				return 1;
			}else{
				return 0;
			}
		}
		
		/**
		 * 销毁存储在session中的验证码
		 */
		public function destoryCode($request){
			$request->session()->forget('msmCode');
			$request->session()->forget('code_mobile');
			return true;
		}
		
		/**
		 * 检查手机号合法性
		 */
		public function checkMobile($mobile){
			$reg = "/^1[0-9]{10}$/";
			$res = preg_match($reg,$mobile);
			return $res;
		}
		
		
	}
