<?php
class Model_User {
	
	public function getUserSummary($userId)
	{
		return $this->_userSummary($userId);
	}
	
	protected function _userSummary($userId)
	{
		$userHosts = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);
		$userServices = Model_DbTable_Factory::getServicesDbTable()->getServicesByUser($userId);
		$checkedAfter = (time() - 604800);
		$serviceChecks = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByUser($userId, NULL, NULL);
		$totalLatency = 0;
		$totalUp = 0;
		$totalDown = 0;
		foreach($serviceChecks as $serviceCheck) {
			$totalLatency = ($totalLatency + $serviceCheck->timetaken);
			if ($serviceCheck->result == 1) {
				$totalUp++;
			} else {
				$totalDown++;
			}
		}
		if ((!empty($serviceChecks)) && (!empty($totalLatency))) {
			$avgLatency = round(( $totalLatency / $serviceChecks->count() ), 2);
		}
		$userSummary = array('hosts' => $userHosts->count(), 'services' => $userServices->count(), 'avg_latency' => $avgLatency,
							 'up_percent' => Model_Factory::getHostStatisticsModel()->calculatePercentage($totalUp, $serviceChecks->count()),
							 'down_percent' => Model_Factory::getHostStatisticsModel()->calculatePercentage($totalDown, $serviceChecks->count()));
		return $userSummary;
	}
	
	protected function _userDetailedSummary($userId)
	{
		$userHosts = Model_DbTable_Factory::getHostsDbTable()->getHostsByUserId($userId);
		foreach ($userHosts as $userHost) {
		$serviceData = '';
		$serviceHosts = Model_DbTable_Factory::getServicesDbTable()->getServicesByHost($userHost->id, $userId);
			foreach($serviceHosts as $serviceHost)
			{
				$checkedAfter = (time() - 604800);
				$serviceChecks = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByUser($userId, $serviceHost->id, $checkedAfter);

				$totalLatency = 0;
				$totalUp = 0;
				$totalDown = 0;
				foreach($serviceChecks as $serviceCheck) {
					if ($serviceCheck->result == 1) {
						$totalUp++;
					} else {
						$totalDown++;
					}
				}
				$serviceData[] = array('name' => $serviceHost->name, 'port' => $serviceHost->port, 
									   'up_percent' => Model_Factory::getHostStatisticsModel()->calculatePercentage($totalUp, $serviceChecks->count()),
									   'down_percent' => Model_Factory::getHostStatisticsModel()->calculatePercentage($totalDown, $serviceChecks->count()),
									   	'avg_latency' => round(($totalLatency / $serviceChecks->count()), 1));
			}
			if (!empty($serviceHosts)) {
				$serviceCount = $serviceHosts->count(); 
			} else {
				$serviceCount = 0;
			}
			$hostData[] = array('host_id' => $userHost->id, 'name' => $userHost->name, 'hostname' => $userHost->hostname, 'services' => array($serviceData), 
								'active_services' => $serviceCount);
		}
		return $hostData;		
	}
	

}
	