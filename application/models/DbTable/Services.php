<?php
class Model_DbTable_Services extends Zend_Db_Table_Abstract {
	protected $_name = 'services';
	protected $_primary = array('id');

	public function checkServiceNameByHost($hostId, $serviceName)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('host_id = ?', $hostId))
					   ->where($this->getAdapter()->quoteInto('name = ?', $serviceName));			   
		return $this->fetchAll($select);			
	}
	
	public function checkServicePortByHost($hostId, $servicePort)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('host_id = ?', $hostId))
					   ->where($this->getAdapter()->quoteInto('port = ?', $servicePort));			   
		return $this->fetchAll($select);						
	}
	
	public function getServicesByHost($hostId, $userId = NULL)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('host_id = ?', $hostId));
		if (!empty($userId)) {
				$select->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		}			   
		return $this->fetchAll($select);						
	}	
	
	public function getActiveServices($hostId = NULL)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('active = ?', 1));
					   
		if (!empty($hostId)) {
			$select->where($this->getAdapter()->quoteInto('host_id = ?', $hostId));
		}	
			   
		return $this->fetchAll($select);		
	}
	
	public function getServicesByUser($userId, $active = NULL)
	{
		$select = $this->select()->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		if ($active == 1) {
				$select->where($this->getAdapter()->quoteInto('active = ?', $active));			
		}
		return $this->fetchAll($select);		 		
	}	
}

	