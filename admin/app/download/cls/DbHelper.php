<?php
	
	class DbHelper {
		
		private $db_host = DH;
		private $db_name = DB;
		private $db_user = DU;
		private $db_pwd = DP;
		private $charset = "utf8";
		
		private $dbh = '';
		
		public function __construct(){
			
			if(!$this->dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd);
			}
			
		}
		
		//获取列表
		public function get_list($sql,$params=array()){
			
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd); 
			}
			if(!count($params)){
				$smt = $this->dbh->query($sql);
			}else{
				$smt = $this->dbh->prepare($sql);
				$smt -> execute($params);
			}
			
			return $smt -> fetchAll();
			
		}
		//获取查询出的第一条数据
		public function get_one($sql,$params=array()){
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd); 
			}
			
			if(!count($params)){
				$smt = $this->dbh->query($sql);
			}else{
				$smt = $this->dbh->prepare($sql);
				$smt -> execute($params);
			}
			
			return $smt -> fetch();
			
		}
		
		//执行sql语句 (一般为插入/删除/更新等不需要返回数据的操作)
		public function execute ($sql, $params = array() ) {
			
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd);
			}

			if (!count($params)){
				$res = $this->dbh->exec($sql);
			} else {
				$smt = $this->dbh->prepare($sql);
				$res = $smt -> execute($params);
			}
				
			return $res;
			
		}
	
		
		//组装 sql 数据片段
		public function prepareSql ($data) {
			
			$resParams = array ();
			
			$sql = " ";
			
			foreach ($data as $key => $v) {
				$sql .= " $key=?, ";
				$resParams[] = $v;
			}
			
			$sql = trim($sql);
			$sql = substr($sql,0,strlen($sql) - 1);
			
			$res = array ( "sql" => $sql, "params" => $resParams );
			
			return $res;
			
		}
		
		//获取最新插入的数据
		public function get_last_insert_id () {
			
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd);
			}
			
			return $this->dbh->lastInsertId();
			
		}
		
		//开始事务
		public function begin_transaction () {
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd);
			}
			$this->dbh->beginTransaction ();
		}
		//提交事务
		public function commit () {
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd);
			}
			$this->dbh->commit ();
		}
		
		//回滚事务
		public function rollback () {
			if(!$this -> dbh){
				$this -> dbh = new \PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=".$this->charset,$this->db_user,$this->db_pwd);
			}
			$this->dbh->rollback ();
		}
		
	}