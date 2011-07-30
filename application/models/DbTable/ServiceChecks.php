<?php
class Model_DbTable_ServiceChecks extends Zend_Db_Table_Abstract {
	protected $_name = 'service_checks';
	protected $_primary = array('id');

	public function getServiceChecksByUser($userId, $serviceId = NULL, $time = NULL)
	{
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		if (!empty($serviceId)) {
			$select->where($this->getAdapter()->quoteInto('service_id = ?', $serviceId));
		}			
		if (!empty($time)) {
			$select->where($this->getAdapter()->quoteInto('checked > ?', $time));
		}			   
		return $this->fetchAll($select);						
	}	
	
}

	