<?php
/**
* 
*/
class recyle_vedio
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

	//根据id 删除回收站中的课程数据
	public function deecourse($catid)
	{
		$data = array('video_course',array(array("AND","courseid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeDelete($data);
		return $this->db->exec($sql);
	}
	public function deevedio($catid)
	{
		$data = array('videos',array(array("AND","videoid = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeDelete($data);
		return $this->db->exec($sql);
	}
	public function deeseeding($catid)
	{
		$data = array('video_special',array(array("AND","vid =:vid",'vid',$catid)));
		$sql = $this->pdosql->makeDelete($data);
		return $this->db->exec($sql);
	}
}

?>