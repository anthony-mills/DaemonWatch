<?php
class Model_Graph {
	
     /**
	 * Graph the latency of all actively checked services on a host over the last 24 hours
	 * 
	 * @param integer $hostid 
	 * @param integer $graphPeriod
	 * 
	 * @return array $serviceChecks
	 */
	public function recentHostLatency($hostId, $graphPeriod = 86400)
	{
		$hostInfo = Model_DbRow_Factory::getHostsDbRow()->getHostById($hostId);
		$hostServices = Model_DbTable_Factory::getServicesDbTable()->getActiveServices($hostId);
		$latencySince = time() - $graphPeriod;
		
		$serviceChecks = array();
		foreach($hostServices as $hostService) {
			$checkResults = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByPeriod($hostService->id, $latencySince);
			
			foreach($checkResults as $checkResult) {
				$serviceChecks[] = array('checkTime' => $checkResult->checked, 'timeTaken' => $checkResult->timetaken);
			}
		} 
		
		return $serviceChecks;
	}
	
	/**
	 * Graph the avg latency of all services on all hosts belonging to a user
	 * 
	 * @param integer $userId
	 * @param integer $graphPeriod
	 * 
	 * @return array 
	 */
	public function recentLatencyAllHosts($userId, $graphPeriod = 86400)
	{
		$userHosts = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);
		$serviceChecks = array();
		
		foreach($userHosts as $userHost) {
			$hostServices = Model_DbTable_Factory::getServicesDbTable()->getActiveServices($userHost->id);
			$latencySince = time() - $graphPeriod;
			
			foreach($hostServices as $hostService) {
				$checkResults = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByPeriod($hostService->id, $latencySince);
				
				foreach($checkResults as $checkResult) {
					$serviceChecks[] = array('checkTime' => $checkResult->checked, 'timeTaken' => $checkResult->timetaken);
				}
			} 
		}
			
		return (array) $serviceChecks;
	}
		
	/** 
	 * Graph the latency of a users particular sevice over time
	 * 
	 * @param integer $serviceId 
	 * @param integer $userId
	 * @param integer $graphPeriod
	 * 
	 * @return array
	 */
	public function recentServiceLatency($serviceId, $userId, $graphPeriod = 86400)
	{
		if (!$latencySince) {
			$latencySince = time() - $graphPeriod;
		}
		$serviceDetails = Model_DbRow_Factory::getServicesDbRow()->getServiceById($serviceId, $userId);
		if (!empty($serviceDetails)) {
			$checkResults = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByPeriod($serviceId, $latencySince);
			foreach($checkResults as $checkResult) {
				$serviceChecks[] = array('checkTime' => $checkResult->checked, 'timeTaken' => $checkResult->timetaken);
			}			
		}
		
		return (array) $serviceChecks;
	}
	
	/**
	 * Graph the uptime of users services over a given period
	 * 
	 * @param integer $userId
	 * @param integer $graphPeriod
	 * 
	 * @return array
	 */
	public function recentUserUptime($userId, $graphPeriod = 86400)
	{
		$userHosts = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);
		$serviceChecks = array();
		$upChecks = (int) 0;
		$downChecks = (int) 0;
		$serviceChecks = (int) 0;

		foreach($userHosts as $userHost) {
			$hostServices = Model_DbTable_Factory::getServicesDbTable()->getActiveServices($userHost->id);
			$latencySince = time() - $graphPeriod;
			
			foreach($hostServices as $hostService) {
				$checkResults = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByPeriod($hostService->id, $latencySince);
				
				foreach($checkResults as $checkResult) {
					if ($checkResult->result == 1) {
						$upChecks++;
					} else {
						$downChecks++;
					}
					$serviceChecks++;
				}
			} 
		}
		$serviceChecks = array('serviceChecks' => $serviceChecks, 'serviceUp' => $upChecks, 'serviceDown' => $downChecks);
			
		return (array) $serviceChecks;		
	}
}
