<?php 
/**
*	日志生成 
*/
class journal
{
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
		$this->user = $this->G->make('user','user');
	}


	public function addJournal($args,$userid=true)
	{	
		if ($userid) {
			$user = $this->userid;
			$args['userid'] = $user['userid'];
		}
		
		$args['eventtime'] = TIME;
		
		return $this->db->insertElement(array('table' => 'journal','query' => $args));
	}
	public function Updateorders($ordersn)
	{
		$data = array(
			'table' => 'orders',
			'value' => $args,
			'query' => array(array("AND","ordersn = :ordersn",'ordersn',$ordersn))
		);
		$this->db->updateElement($data);
		return $this->db->affectedRows();
	}
}




?>