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
	
	
	/**
	 * Get all of the service checks that have been performed on a service within a given time frame  
	 */
	public function getServiceChecksByPeriod($serviceId, $fromTime = NULL, $toTime = NULL) {
		$select = $this->select()
					   ->where($this->getAdapter()->quoteInto('service_id = ?', $serviceId));
					   
		if (!empty($fromTime)) {
			$select->where($this->getAdapter()->quoteInto('checked > ?', $fromTime));			
		}		

		if (!empty($toTime)) {
			$select->where($this->getAdapter()->quoteInto('checked < ?', $toTime));			
		}		

		return $this->fetchAll($select);	
	}
	
}

	