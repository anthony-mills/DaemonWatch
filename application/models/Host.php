<?php
class Model_Host {
	protected $_hostDbTableName = 'hosts';
		
    public function addNewHost($hostData) 
    {
    	if ((empty($hostData['name'])) || (empty($hostData['hostName']))) {
    		return FALSE;
    	}
		if (empty($hostData['userId'])) {
			$userId = Zend_Registry::get('user_id');		
		}	
			
		// Check the user is allowed to add more hosts
		$result = $this->checkUserHostNumber($userId);
		if (!$result) {
			return array('You have reached your host limit');
		}
		unset($result);
		
		// Check the name of the host is unique
		$result = $this->checkUserHostName($userId, $hostData['name']);
		if (!empty($result)) {
			return array('A host with that name already exists.');
		}
		unset($result);
		
		// Check the name of the host is unique
		$result = $this->checkUserHostName($userId, $hostData['hostName']);
		if (!empty($result)) {
			return array('A host with that hostname already exists.');
		}				
			
		$hostData = array('name' => $hostData['name'], 'hostname' => $hostData['hostName'], 'user_id' => $userId, 'created' => time());
		$hostRow = Model_DbRow_Factory::getHostsDbRow()->addNewHost($hostData);
		return TRUE;
	}
	
	public function updateExistingHost($hostData, $userId = NULL)
	{
    	if ((empty($hostData['name'])) || (empty($hostData['hostName'])) || (empty($hostData['hostId']))) {
    		return FALSE;
    	}		
		if (empty($hostData['userId'])) {
			$userId = Zend_Registry::get('user_id');
		}
		$result = Model_DbTable_Factory::getHostsDbTable()->getUserHostsByName($userId, $hostData['name'], $hostData['hostId'])->toArray();
		if (count($result) > 0) {
			return array('You already have a host with that name');
		}
		$result = FALSE;
		
		$result = Model_DbTable_Factory::getHostsDbTable()->getUserHostsByHostName($userId, $hostData['hostName'], $hostData['hostId'])->toArray();
		if (count($result) > 0) {
			return array('You already have a host with that host name or IP address');
		}
		$hostId = $hostData['hostId'];
		unset($hostData['hostId']);
		Model_DbRow_Factory::getHostsDbRow()->updateHostById($hostId, $hostData);
		
	}
	
	public function checkUserName($userId, $name)
	{
		$userRow = Model_DbRow_Factory::getUsersDbRow()->getUserById($userId);
		if (!$userRow) {
			return FALSE;
		}
		$namedHosts = Model_DbTable_Factory::getHostsDbTable()->getUserHostsByName($userId, $name);		
		if (!$namedHosts) {
			return FALSE;
		} else {
			return $namedHosts->count();
		}
	}
	
	public function checkUserHostName($userId, $hostName) {
		$userRow = Model_DbRow_Factory::getUsersDbRow()->getUserById($userId);
		if (!$userRow) {
			return FALSE;
		}
		$hostNames = Model_DbTable_Factory::getHostsDbTable()->getUserHostsByHostName($userId, $hostName);		
		if (!$hostNames) {
			return FALSE;
		} else {
			return $hostNames->count();
		}		
	} 
		
	public function checkUserHostNumber($userId)
	{
		$userRow = Model_DbRow_Factory::getUsersDbRow()->getUserById($userId);
		if (!$userRow) {
			return FALSE;
		}	
		$hostCount = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);	
		if ($hostCount->count() < $userRow->max_hosts) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getUserHosts($userId)
	{
		$results = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);
		if (!$results) {
			return FALSE;
		} else {
			return $results->toArray();
		}
	}
	
	public function getHostById($hostId, $userId = NULL)
	{
		$result = Model_DbRow_Factory::getHostsDbRow()->getHostById($hostId, $userId);
		return $result;
	}

	public function getUserHostsById($hostId, $userId = NULL)
	{
		$results = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);
		if (!$results) {
			return FALSE;
		} else {
			return $results->toArray();
		}
	}
		
	public function deleteHost($hostId, $userId = NULL)
	{
		$result = Model_DbRow_Factory::getHostsDbRow()->deleteHost($hostId, $userId);
	}
}
	