<?php

class orders_bank
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->ev = $this->G->make('ev');
		$this->files = $this->G->make('files');
		$this->pg = $this->G->make('pg');
	}

	public function getOrderList($args,$page,$number = 20)
	{

		$page = $page > 0?$page:1;

		$r = array();
		$data = array('DISTINCT orders.*,user.username',array('orders','user'),$args,'orders.orderid DESC','',array(intval($page-1)*$number,$number));
		$sql = $this->pdosql->makeSelect($data);
		
		$r['data'] = $this->db->fetchAll($sql);

		$data = array('count(*) AS number',"orders",$args,false);
		$sql = $this->pdosql->makeSelect($data);

		$t = $this->db->fetch($sql);

		$pages = $this->pg->outPage($this->pg->getPagesNumber(intval($t['number']),$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		
		return $r;
	}

	public function delOrder($id)
	{
		return $this->db->delElement(array('table' => 'orders','query' => array(array("AND","ordersn = :ordersn",'ordersn',$id))));
	}

	public function modifyOrder($id,$args)
	{
		$data = array(
			'table' => 'orders',
			'value' => $args,
			'query' => array(array("AND","ordersn = :ordersn",'ordersn',$id))
		);
		$this->db->updateElement($data);
		return $this->db->affectedRows();
	}

	public function addOrder($args)
	{
		return $this->db->insertElement(array('table' => 'orders','query' => $args));
	}

	public function getOrderById($id)
	{
		
		$data = array("orders.*,user.usertruename",array('orders',"user"),array(array("AND","orders.orderid = :orderid",'orderid',$id),array('AND','orders.orderuserid = user.userid')));
		$sql = $this->pdosql->makeSelect($data);
		
		return $this->db->fetch($sql);
	}
	
	public function modifyOrderById($id,$args)
	{
		$data = array('orders',$args,array(array("AND","ordersn = :ordersn",'ordersn',$id)));
		$sql = $this->pdosql->makeUpdate($data);
		return $this->db->exec($sql);
	}

	public function addSaledItem($args)
	{
		return $this->db->insertElement(array('table' => 'saleditems','query' => $args));
	}

}

?>
