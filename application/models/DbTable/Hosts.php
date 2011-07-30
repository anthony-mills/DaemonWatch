<?php
class Model_DbTable_Hosts extends Zend_Db_Table_Abstract {
	protected $_name = 'hosts';
	protected $_primary = array('id');

	public function getHostsByUserId($userId)
	{
		$select = $this->select()->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		return $this->fetchAll($select);		 
	}
	
	public function getUserHostsByName($userId, $name, $hostId = NULL)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('user_id = ?', $userId))
					   ->where($this->getAdapter()->quoteInto('name = ?', $name));
					   
		if (!empty($hostId)) {
			$select->where($this->getAdapter()->quoteInto('id != ?', $hostId));
		}					   
		return $this->fetchAll($select);			
	}

	public function getUserHostsByHostName($userId, $hostName, $hostId = NULL)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('user_id = ?', $userId))
					   ->where($this->getAdapter()->quoteInto('hostname = ?', $hostName));
					   
		if (!empty($hostId)) {
			$select->where($this->getAdapter()->quoteInto('id != ?', $hostId));
		}						   
		return $this->fetchAll($select);			
	}		
}

	