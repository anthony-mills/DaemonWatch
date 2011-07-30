<?php

class ServicesController extends Zend_Controller_Action
{
	protected $_hostId = NULL;
	protected $_userId = NULL;
	
    public function init()
    {
    	$this->_userId = Zend_Registry::get('user_id');
		$this->_hostId = $this->_request->getParam("hostId");
    }

	public function addAction()
	{
		$this->_hostId = $this->_checkParameter($this->_hostId);			
		$addServiceForm = new Form_AddService();
		$formData = $this->_request->getPost();
		
		if ((!empty($formData)) && ($addServiceForm->isValid($formData))) {
			if (!empty($formData['sms'])) {
				$formData['sms'] = 1;
			} else {
				$formData['sms'] = 0;
			}
			$serviceData = array('name' => trim($formData['name']), 'port' => trim($formData['port']), 'active' => 1, 
								 'host_id' => $this->_hostId, 'frequency' => $formData['serviceFrequency'], 'sms' => $formData['sms'],
								 'user_id' => $this->_userId, 'created' => time(), 'updated' => time());

			$result = Model_Factory::getServicesModel()->addNewService($serviceData);
			if (!$result) {
				$this->view->errors = array('Unable to save host');	
			} elseif (is_array($result)) {
				$this->view->errors = $result;
				$this->view->formData = $formData;
			} else {
				$this->view->errors = array('Service successfully saved');
			} 
		} else {
			$this->view->errors = $addServiceForm->getMessages();
		}
		$this->view->js = array('validate.js', 'select_skin.js', 'html5_placeholders.js','handlers/services/add.js');
	}

	public function viewAction()
	{
		if ((empty($this->_hostId)) && (!is_numeric($this->_hostId))) {
			$this->_redirect('user/home');
			exit; 
		}		
		$this->view->hostServices = Model_Factory::getServicesModel()->getHostServices($this->_hostId, $this->_userId);	
		$this->view->js = array('facebox.js', 'handlers/services/view.js');		
	}
	
	public function toggleChecksAction()
	{
		$this->_helper->layout()->disableLayout();
		$serviceId = $this->_request->getParam("serviceId");
		$serviceStatus = $this->_request->getParam("newstatus");
		if (($serviceStatus == 'active') || ($serviceStatus == 'pause')) {
			switch ($serviceStatus) {
				case 'active':
					$serviceStatus = 1;
				break;
				
				case 'pause':
					$serviceStatus = 0;
				break;				
			}
			$this->_helper->viewRenderer->setNoRender(true);  
			$this->view->hostServices = Model_Factory::getServicesModel()->toggleServiceStatus($serviceStatus, $serviceId, $this->_userId);
			$this->_redirect('services/view/hostId/' . $this->_hostId);
			exit; 				
		} else {
			$this->view->serviceDetails = array('hostId' => $this->_hostId, 'serviceId' => $serviceId, 'currentStatus' => $this->_request->getParam("status"));
		}	
	}
	
	public function deleteAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$serviceId =  $this->_request->getParam("serviceId");
		$confirmed =  $this->_request->getParam("confirmed");
		
		if ((!empty($serviceId)) && (is_numeric($serviceId)) && ($confirmed == 1)) {
			$result = Model_Factory::getServicesModel()->deleteHost( (int) $serviceId, $this->_userId);
			$this->_redirect('services/view/hostId/' . $this->_hostId);
			exit; 			
		}
		
		if ((!empty($serviceId)) && (is_numeric($serviceId))) {
			$this->view->serviceId = $serviceId;
			$this->view->hostId = $this->_hostId;
		} else {
			$this->_redirect('user/home');
			exit; 				
		}
	}
	
	public function editAction()
	{
		$serviceId = $this->_checkParameter($this->_request->getParam("serviceId"));
		
		$addServiceForm = new Form_AddService();
		$formData = $this->_request->getPost();
		if (!empty($formData)) {
			if ($addServiceForm->isValid($formData)) {
				$serviceData = array('name' => trim($formData['name']), 'port' => trim($formData['port']), 
									 'frequency' => $formData['frequency'], 'user_id' => $this->_userId, 
									 'updated' => time(), 'id' => $serviceId, 'host_id' => $this->_hostId);
				$result = Model_Factory::getServicesModel()->updateService($serviceId, $serviceData, $this->_userId);
				if (!$result) {
					$this->view->errors = array('Unable to update host');
				} elseif (is_array($result)) {
					$this->view->errors = $result;
					$this->view->formData = $formData;
				} else {
					$this->view->formData = $formData;
					$this->view->errors = array('Service successfully updated');
				} 
			} else {
				$this->view->errors = $addServiceForm->getMessages();
			}		
		} else {
			$this->view->formData = Model_Factory::getServicesModel()->getServiceById($serviceId, $this->_userId);	
		}
		$this->view->js = array('validate.js', 'select_skin.js', 'html5_placeholders.js', 'facebox.js', 'handlers/services/edit.js');		
	}

	private function _checkParameter($parameter = NULL)
	{
		if ((empty($parameter)) && (!is_numeric($parameter))) {
			$this->_redirect('user/home');
			exit; 
		}		
		return $parameter;
	}
}