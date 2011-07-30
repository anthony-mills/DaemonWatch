<?php
class Model_Services {
	protected $_userDbTableName = 'services';
		
    public function addNewService($hostData) 
    {
		if (is_array($hostData)) {
			
			$serviceCount = Model_DbTable_Factory::getServicesDbTable()->checkServiceNameByHost($hostData['host_id'], $hostData['name']);
			
			if (count($serviceCount) > 0) {
				return array('Your service name must be unique for the host');
			}
			
			$serviceCount = Model_DbTable_Factory::getServicesDbTable()->checkServicePortByHost($hostData['host_id'], $hostData['port']);
			
			if (count($serviceCount) > 0) {
				return array('This host already has an existing service on this port');
			}			
			
			$serviceId = Model_DbRow_Factory::getServicesDbRow()->addNewService($hostData);
			return $serviceId;
		} else {
			return FALSE;
		}
    }
	
	public function updateService($serviceId, $serviceData, $userId)
	{
		if (is_array($serviceData)) {
			
			$serviceCount = Model_DbRow_Factory::getServicesDbRow()->checkServiceNameByHost($serviceData['name'], $serviceId, $userId);
			
			if (!empty($serviceCount)) {
				return array('Your service name must be unique for the host');
			}
			
			$serviceCount = Model_DbRow_Factory::getServicesDbRow()->checkServicePortByHost($serviceData['host_id'], $serviceData['port'], $serviceId, $userId);

			if ((!empty($serviceCount)) && ($serviceCount['id'] != $serviceId)) {
				return array('This host already has an existing service on this port');
			}	
			$serviceData['id'] = $serviceId; 
			$serviceId = Model_DbRow_Factory::getServicesDbRow()->updateService($serviceData, $userId);
			return TRUE;
		} else {
			return FALSE;
		}		
	}
	
	public function getHostServices($hostId, $userId = NULL)
	{
		$results = Model_DbTable_Factory::getServicesDbTable()->getServicesByHost($hostId, $userId);
		if (!$results) {
			return FALSE;
		} else {
			return $results->toArray();
		}
	}
	
	public function deleteHost($serviceId, $userId)
	{
		$result = Model_DbRow_Factory::getServicesDbRow()->deleteService($serviceId, $userId);		
	}
	
	public function getServiceById($serviceId, $userId = NULL)
	{
		$result = Model_DbRow_Factory::getServicesDbRow()->getServiceById($serviceId, $userId);
		if (!empty($result)) {
			return $result->toArray();
		}
	}
	
	public function toggleServiceStatus($serviceStatus, $serverId, $userId = NULL)
	{
		Model_DbRow_Factory::getServicesDbRow()->toggleServiceStatus($serviceStatus, $serverId, $userId);
	}	
	
		
}
	