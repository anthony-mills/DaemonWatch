<?php
class Model_HostStatistics {
		
	public function getServiceStatistics($serviceId, $userId, $fromTime = NULL, $toTime = NULL)
	{
		$serviceDetails = Model_DbRow_Factory::getServicesDbRow()->getServiceById($serviceId, $userId);
		if (!empty($serviceDetails)) {
			$nowTime = (int) time();
			if (!$fromTime) {
				$fromTime = (int) $nowTime - 86400;
				$periodMesured = '24 hours';
			} else {
				$fromTime = (int) $time - $fromTime;
				$periodMesured = floor(($nowTime - $fromTime)/60*60*24) . ' days';
			}
			$checkResults = Model_DbTable_Factory::getServiceChecksDbTable()->getServiceChecksByPeriod($serviceId, $fromTime, $toTime);
			if (!$checkResults) {
				$serviceDetails = array('last_check' => 'N/A', 'uptime' => 'N/A', 'last_outage' => 'N/A', 'avg_latency' => 'N/A', 'service_name' => $serviceDetails->name,
									  'service_added' => $serviceDetails->created, 'service_port' => $serviceDetails->port, 'highest_latency' => 'N/A',
									  'lowest_latency' => 'N/A', 'uptime_percentage' => 'N/A', 'downtime_percentage' => 'N/A');
			} else {
				$serviceUptime = $this->_serviceUptime($checkResults);
				$serviceUptime['service_added'] = $serviceDetails->created; 
				$serviceUptime['service_name'] = $serviceDetails->name;
				$serviceUptime['service_port'] = $serviceDetails->port;  
			}
			
			$serviceUptime['period_mesured'] = $periodMesured;
			$serviceUptime['service_id'] = $serviceId;

			return $serviceUptime;
		}
		return FALSE;
	}
	
	/**
	 * Calculate the percentage one number is of another number
	 */	
	public function calculatePercentage($number, $total)
	{
		return round($number * 100 / $total);
	}
	
	/**
	 * Calculate the uptime as a percentage from a bunch of sevice checks
	 */
	protected function _serviceUptime($serviceChecks)
	{
		$serviceStatistics = array('service_checks' => count($serviceChecks->toArray()));
		$totalLatency = 0;
		$highestLatency = 0;
		$lowestLatency = 0;
		$upChecks = 0;
		$downChecks = 0;
		
		foreach($serviceChecks as $serviceCheck) {
			if (($serviceCheck->result == 0) && (empty($serviceStatistics['last_outage']))) {
				$serviceStatistics['last_outage'] = $serviceCheck['checked'];
			}
			$totalLatency = ($totalLatency + $serviceCheck->timetaken);
			
			if ($lowestLatency == 0) {
				$lowestLatency = $serviceCheck->timetaken;	
			} elseif ($serviceCheck->timetaken < $lowestLatency) {
				$lowestLatency = $serviceCheck->timetaken;
			}

			if ($highestLatency == 0) {
				$highestLatency = $serviceCheck->timetaken;	
			} elseif ($serviceCheck->timetaken > $highestLatency) {
				$highestLatency = $serviceCheck->timetaken;
			}
						
			if ($serviceCheck->result == 1) {
				$upChecks++;
			} else {
				$downChecks++;
			}
		}
		
		if (empty($serviceStatistics['last_outage'])) {
			$serviceStatistics['last_outage'] = 'None recorded';
		}
		$serviceStatistics['uptime_percentage'] = $this->calculatePercentage($upChecks, $serviceStatistics['service_checks']) . '%';
		$serviceStatistics['downtime_percentage'] = $this->calculatePercentage($downChecks, $serviceStatistics['service_checks']) . '%';	
		$serviceStatistics['avg_latency'] =  round($totalLatency / $serviceStatistics['service_checks']) . 'ms';
		$serviceStatistics['highest_latency'] = $highestLatency . 'ms';
		$serviceStatistics['lowest_latency'] = $lowestLatency . 'ms';					
		
		return $serviceStatistics;
	}
		
}
	