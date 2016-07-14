<?php 
 
class question_document
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->ev = $this->G->make('ev');
	}
/**
 * [getQuestionSubjectById  根据传入的参数(单条件)获取单条信息]
 * @param  [type] $table  数据表名
 * @param  [type] $id     条件字段名
 * @param  [type] $catid  条件值
 * @return [type] array   返回数组
 */
	public function getQuestionSubjectById($table,$tb_pre,$catid)
	{
		$data = array(false,$table,array(array('AND',"".$tb_pre." = :catid",'catid',$catid)));
		$sql = $this->pdosql->makeSelect($data);

		return $this->db->fetch($sql);
	}

/**
 * [getQuestionSubjectList 获取questions_sub表中is_correcting值为0的数据]
 * @return [type] [array]  返回数组
 */
	public function getQuestionSubjectList($page,$number=20,$catid,$quesid)
	{
		$page = $page > 0?$page:1;
		$r = array();

		$data = array(false,array('questions_sub','user','questype'),array(array('AND',"questions_sub.userid = user.userid"),array('AND',"questions_sub.subtype = questype.questid"),array('AND',"questionid = :questid",'questid',$quesid),array('AND',"is_correcting = :catid",'catid',$catid),array('AND',"orderid = :bid",'bid',1)),'questions_sub.subid DESC','',array(intval($page-1)*$number,$number));
		$sql = $this->pdosql->makeSelect($data);

		$r['data'] = $this->db->fetchAll($sql);

		$data = array('count(*) AS number',array('questions_sub','user','questype'),array(array('AND',"questions_sub.userid = user.userid"),array('AND',"questions_sub.subtype = questype.questid"),array('AND',"questionid = :questid",'questid',$quesid),array('AND',"is_correcting = :catid",'catid',$catid),array('AND',"orderid = :bid",'bid',1)));
		$sql = $this->pdosql->makeSelect($data);
		$t = $this->db->fetch($sql);

		$pages = $this->pg->outPage($this->pg->getPagesNumber(intval($t['number']),$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}
	/**
	 * [getSubjectiveList description]
	 * @param  [type] $id   [description]
	 * @param  [type] $args [description]
	 * @return [type]       [description]
	 */
	public function getSubjectiveList($id,$args)
	{
		$data = array('questions_sub',$args,array(array("AND","subid = :catid",'catid',$id)));
		$sql = $this->pdosql->makeUpdate($data);
		
		$this->db->exec($sql);
		return true;
	}

}



?>