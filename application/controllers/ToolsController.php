<?php

class ToolsController extends Zend_Controller_Action
{
	protected $_userId;

    public function init()
    {
		$this->_userId = (int) Zend_Registry::get('user_id');
    }

	public function indexAction()
	{
		$this->_redirect('user/home');	
	}

	
	public function tracerouteAction()
	{
		$tracerouteForm = new Form_Tools_Traceroute();
		
		if ($this->_request->isPost()) {
			$formData = $this->_request->getParams();
		    if ($tracerouteForm->isValid($formData)) {
		    	$validator = new Zend_Validate_Hostname(Zend_Validate_Hostname::ALLOW_IP | Zend_Validate_Hostname::ALLOW_DNS);
				if ($validator->isValid($formData['hostname'])) {		 
					$traceRoute = new Shared_Network_Traceroute();
					$traceRouteResult = $traceRoute->tracerouteHost($formData['hostname']);
				
					if ($traceRouteResult['error'] == 0) {
						$traceRouteResult['msg'][0] = '<strong>' . ucfirst($traceRouteResult['msg'][0]) . '</strong>';
						$this->view->tracerouteResult = $traceRouteResult['msg'];
					} else {
						$this->view->tracerouteError = array($traceRouteResult['msg']);
					}
				} else {
					$this->view->tracerouteError = array('Please enter a valid hostname<br />');
				}
			} else {
				$this->view->tracerouteError = array('Please enter a valid hostname<br />');				
			}
		}
		
		$this->view->js = array('validate.js', 'html5_placeholders.js', 'handlers/tools/traceroute.js');	
	}

}
