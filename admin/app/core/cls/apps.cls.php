<?php

class apps_core
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->ev = $this->G->make('ev');
			$this->pg = $this->G->make('pg');
		$this->files = $this->G->make('files');

	}

	//根据应用名获取应用信息
	public function getApp($appid)
	{
		$data = array(false,'app',array(array("AND","appid = :appid","appid",$appid)));
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql,array('appsetting',"appusersetting"));
	}

	//修改应用信息
	public function modifyApp($appid,$args)
	{
		$data = array('app',$args,array(array("AND","appid = :appid","appid",$appid)));
		$sql = $this->pdosql->makeUpdate($data);
		return $this->db->exec($sql);
	}

	//添加应用信息
	public function addApp($appid,$args)
	{
		$args['appid'] = $appid;
		$data = array('app',$args);
		$sql = $this->pdosql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	//获取本地应用列表
	public function getLocalAppList()
	{
		return $this->files->listDir('app');
	}

	//获取数据库内应用列表
	public function getAppList($args = 1)
	{
		$data = array(false,'app',$args,false,false,false);
		$sql = $this->pdosql->makeSelect($data);
		$r = $this->db->fetchAll($sql,'appid','appsetting');
		foreach($r as $key => $p)
		{
			if(!file_exists('app/'.$key))unset($r[$key]);
		}
		return $r;
	}

	public function getConfigList($cfid)
	{
		$data = array(false,'config',array(array("AND","cfid = :cfid","cfid",$cfid)));
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql);
	}
	public function getSmsmobileList()
	{
		$data = array(false,'smsmobile',false);
		$sql = $this->pdosql->makeSelect($data);
	
		return $this->db->fetch($sql);
	}
	public function getPlayAPI($id)
	{
		$data = array(false,'playapi',array(array("AND","cfid = :cfid","cfid",$id)));
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql);
	}
	public function getJournalList($page,$number=20)
	{
		$page = $page > 0?$page:1;

		$r = array();
		$data = array('DISTINCT journal.*,user.usertruename,user.username',array('journal','user'),array(array('and','journal.userid=user.userid')),'eventtime DESC','',array(intval($page-1)*$number,$number));
		
		$sql = $this->pdosql->makeSelect($data);
	
		$r['data'] = $this->db->fetchAll($sql);

		$data = array('count(*) AS number',"journal");
		$sql = $this->pdosql->makeSelect($data);

		$t = $this->db->fetch($sql);

		$pages = $this->pg->outPage($this->pg->getPagesNumber(intval($t['number']),$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
		
	}
	public function deleDayList($time)
	{	
		$number1 = $this->deleDayListNumber();
		$data = array('journal',array(array("AND"," eventtime <=:eventtime",'eventtime',$time)));
		$sql = $this->pdosql->makeDelete($data);
		$this->db->exec($sql);
		$number2 = $this->deleDayListNumber();
		$number = $number1['number'] -$number2['number'];
		return  $number;

	}
	public function deleDayListNumber()
	{
		$data = array('count(*) AS number',"journal");
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql);
	}
}

?>