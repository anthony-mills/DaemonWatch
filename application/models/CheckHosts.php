<?php
class Model_CheckHosts {
	protected $_authAdapter;
		
 	public function checkNeededServices()
	{
		$results = Model_DbTable_Factory::getServicesDbTable()->getActiveServices();
		if (!empty($results)) {
			// $results = $results->toArray();
			foreach($results as $result) {
				$hostData = Model_DbRow_Factory::getHostsDbRow()->getHostById($result['host_id']);
				if ((empty($hostData)) || (($result->checked + $result->frequency) < time())) {
					$startCheck = microtime(true);
					$checkResult = $this->_connectToService($hostData['hostname'], $result->port);
					$checkTime = round(((microtime(true) - $startCheck) * 1000), 2);
					$checked = time();
					$checkData = array('host_id' => $result->host_id, 'service_id' => $result->id, 'checked' => $checked, 
										'timetaken' => $checkTime, 'result' => $checkResult, 'user_id' => $result->user_id);

					Model_DbRow_Factory::getServiceChecksDbRow()->saveHostCheck($checkData);
					$serviceData = array('id' => $result['id'], 'checked' => $checked);
					Model_DbRow_Factory::getServicesDbRow()->updateService($serviceData);
				}
			}
			
		} else {
			return false;
		}
	}
	
	protected function _connectToService($hostName, $servicePort)
	{
		$hostConnection = @fsockopen($hostName, $servicePort, $errno, $errstr, 4);
		if ($hostConnection) {
			fclose($hostConnection);
			return 1;
		} else {
			return 0;
		}
	}
}
	