<?php
	
	namespace App\Plugins\Valid;
	
	class Valid {
		
	    private  $rule_reg = [
	        'require'  => '/\S+/',
	        'email'    => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
	        'url'      => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
	        'number'   => '/^\d+$/',
	        'integer'  => '/^[-\+]?\d+$/',
	        'double'   => '/^[-\+]?\d+(\.\d+)?$/',
	        'english'  => '/^[A-Za-z]+$/',
	        'mobile'   => '/^1\d{10}$/'
	    ];
		
		private $msg = [
			'require'  => '不能为空',
	        'email'    => '格式不正确',
	        'url'      => 'url格式不正确',
	        'number'   => '必须为数字',
	        'integer'  => '必须为整型数字',
	        'double'   => '必须为double型数字',
	        'english'  => '必须为英文字母',
	        'mobile'   => '格式不正确'
		];
		
		private $res = array("status"=>"1","msg"=>"");
		
		public function rule ($request,$arr) {
			foreach ($arr as $name => $val) {
				
				$input = $request->input($name);
				
				$val_sep = explode('@', $val);
				$rules = $val_sep[0];
				$tips_name = isset($val_sep[1]) ? $val_sep[1] : '';//提示字段名
				
				$rules_arr = explode('|', $rules);
				foreach ($rules_arr as $rule) {
					if(!preg_match($this->rule_reg[$rule], $input)){
						$err_msg = $this->msg[$rule];
						$err_msg = $tips_name.$err_msg;
						throw new \Exception($err_msg);
					}
				}
			}
		}
	}
