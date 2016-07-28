<?php

class vedio_vedio 
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->ev = $this->G->make('ev');
	}
	//获取所有课程列表
	public function getkecheng($args =1)
	{
		$data = array(false,'video_course',$args);
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetchAll($sql);
	}
	// 获取视频分类列表
	
	public function getVediocat($args =1)
	{
		$data = array(false,'vedio_cat',$args);
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetchAll($sql);
	}
	//根据分类ID获取信息
	public function setVediocat($catid)
	{
		$data = array(false,'vedio_cat',array(array("AND","catid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql);
	}
	public function setVediocatpid($catpid)
	{
		$data = array(false,'vedio_cat',array(array("AND","catpid = :catpid",'catpid',$catpid)));
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql);
	}
	//根据分类ID修改信息
	public function editVediocat($catid,$args)
	{
		$data = array('vedio_cat',$args,array(array("AND","catid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeUpdate($data);

		$this->db->exec($sql);
		return true;
	}
	//根据分类ID删除信息
	public function deeVediocat($catid)
	{
		$data = array('vedio_cat',array(array("AND","catid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeDelete($data);
		return $this->db->exec($sql);
	}
//获取分页
	public function getVediocourseList($page,$number = 20,$is_delet)
	{

		$page = $page > 0?$page:1;

		$r = array();
		$data = array('DISTINCT *',"video_course",array(array("and","is_delet = :delet",'delet',$is_delet)),'courseid DESC','',array(intval($page-1)*$number,$number));
		
		$sql = $this->pdosql->makeSelect($data);
	
		$r['data'] = $this->db->fetchAll($sql);

		$data = array('count(*) AS number',"video_course",array(array("and","is_delet = :delet",'delet',$is_delet)),false);
		$sql = $this->pdosql->makeSelect($data);

		$t = $this->db->fetch($sql);

		$pages = $this->pg->outPage($this->pg->getPagesNumber(intval($t['number']),$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	//根据id修改课程信息
	public function getEditCourse($catid,$args)
	{
		$data = array('video_course',$args,array(array("AND","courseid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeUpdate($data);
	
		$this->db->exec($sql);
		return true;
	}
	//根据id获取课程信息
	public function getCourse($catid)
	{
		$data = array(false,'video_course',array(array("AND","courseid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeSelect($data);
		
		return $this->db->fetch($sql);
	}
	//根据id 将课程信息移动到回收站
	public function deecourse($catid,$args)
	{

		$data = array('video_course',$args,array(array("AND","courseid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeUpdate($data);
		$this->db->exec($sql);
		return true;	
	}
//获取视频管理分页
		public function getVedioVediolis($page,$number = 20,$is_delet)
	{

		$page = $page > 0?$page:1;

		$r = array();
		$data = array('DISTINCT *',"videos",array(array("and","is_delet = :delet",'delet',$is_delet)),'videoid DESC','',array(intval($page-1)*$number,$number));
		
		$sql = $this->pdosql->makeSelect($data);
	
		$r['data'] = $this->db->fetchAll($sql);

		$data = array('count(*) AS number',"videos",array(array("and","is_delet = :delet",'delet',$is_delet)),false);
		$sql = $this->pdosql->makeSelect($data);

		$t = $this->db->fetch($sql);

		$pages = $this->pg->outPage($this->pg->getPagesNumber(intval($t['number']),$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}
	public function getVediolist($videoid)
	{
		$data = array(false,'videos',array(array("AND","videovid = :videoid",'videoid',$videoid)));
		$sql = $this->pdosql->makeSelect($data);
		
		return $this->db->fetch($sql);
	}
	//根据id 获取视频信息
	public function getVediovideo($videoid)
	{
		$data = array(false,'videos',array(array("AND","videoid = :videoid",'videoid',$videoid)));
		$sql = $this->pdosql->makeSelect($data);
		
		return $this->db->fetch($sql);
	}
	//根据id 修改视频信息
	public function editVediovedio($catid,$args)
	{
		$data = array('videos',$args,array(array("AND","videoid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeUpdate($data);

		$this->db->exec($sql);
		return true;
	}
	public function getCourseVideo($args)
	{
		$data = array(false,'videos',$args);
		$sql = $this->pdosql->makeSelect($data);
		
		return $this->db->fetchAll($sql);
	}
	public function getCourseVideo1($args)
	{
		$data = array(false,'videos',$args);
		$sql = $this->pdosql->makeSelect($data);
		
		return $this->db->fetch($sql);
	}
	public function deevedio($catid,$args)
	{
		$data = array('videos',$args,array(array("AND","videoid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeUpdate($data);
		$this->db->exec($sql);
		return true;
	}

	public function getSubjectList($args,$page,$number = 10)
	{
		$data = array(
			'select' => false,
			'table' => 'videos',
			'query' => $args,
			'orderby' => 'createtime DESC'
		);
		return $this->db->listElements($page,$number,$data);
	}
	public function getSeedingList($args,$page,$number=10,$is_delet)
	{
		$page = $page > 0?$page:1;

		$r = array();
		$data = array('DISTINCT video_special.*,user.usertruename',array('video_special','user'),array(array('AND','video_special.uid = user.userid'),array("and","video_special.is_delet = :delet",'delet',$is_delet)),'video_special.vid DESC','',array(intval($page-1)*$number,$number));
		
		$sql = $this->pdosql->makeSelect($data);
		
		$r['data'] = $this->db->fetchAll($sql);

		$data = array('count(*) AS number',"video_special",array(array("and","is_delet = :delet",'delet',$is_delet)),false);
		$sql = $this->pdosql->makeSelect($data);

		$t = $this->db->fetch($sql);

		$pages = $this->pg->outPage($this->pg->getPagesNumber(intval($t['number']),$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}
	public function getSeedingById($catid)
	{
		$data = array(false,'video_special',array(array('AND','vid=:vid','vid',$catid)));
		$sql = $this->pdosql->makeSelect($data);
		return $this->db->fetch($sql);
	}
	public function getSeedingDelet($catid,$args)
	{
		$data = array('video_special',$args,array(array("AND","vid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeUpdate($data);

		$this->db->exec($sql);
                
		return true;
	}

}

?>