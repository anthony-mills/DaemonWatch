<?php

class Shared_Network_Traceroute {
	private $_traceOutput = '';
	
	/**
	 * 
	 * Perform traceroute on network host
	 * 
	 * @input string $targetHost
	 * @return array
	 */
	public function tracerouteHost($targetHost)
	{
		$targetIP = gethostbyname($targetHost);
		
		if ($targetIP !== long2ip(ip2long($targetIP))) {
			$traceResult = array('error' => 1, 'msg' => 'IP could not be found for host');
			
			return $traceResult;		
		}
		exec('traceroute ' . $targetIP, $this->_traceOutput);
			
		return array('error' => 0, 'msg' => $this->_traceOutput);
		
	}		
}
	