<?php

class StatisticsController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout()->disableLayout();
	}

	public function serviceStatsAction()
	{
		$serviceId =  $this->_request->getParam("service");
		$reportPeriod =  $this->_request->getParam("period");

		if ((!$serviceId) || (!$reportPeriod)) {
			$this->_redirect('user/home');
			exit; 			
		} 
		$fromTime = $this->_request->getParam("fromTime");
		if (empty($fromTime)) {
			$fromTime = NULL;
		}
		$this->view->serviceInformation = Model_Factory::getHostStatisticsModel()->getServiceStatistics($serviceId, $this->_userId, $fromTime);
		
		$this->view->graphData = Model_Factory::getGraphModel()->recentServiceLatency($serviceId, $this->_userId);
		$this->view->js = array('jquery.jqplot.min.js', 'graph/jqplot.canvasAxisLabelRenderer.min.js', 'graph/jqplot.canvasTextRenderer.js');	
	}
}